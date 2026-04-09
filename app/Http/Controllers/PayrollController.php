<?php

namespace App\Http\Controllers;

use App\Models\DispatchTrip;
use App\Models\PayrollPersonLedger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PayrollPayment;
use App\Models\AllowanceRange;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    public function downloadPDF($type, $id)
    {
        $weekStart = request('week_start');
        $weekEnd = request('week_end');

        if ($type === 'driver') {
            $data = $this->getDriverPayroll($id, $weekStart, $weekEnd);
        } else {
            $data = $this->getHelperPayroll($id, $weekStart, $weekEnd);
        }

        $data['person_type'] = $type;

        // ✅ GET PAYMENT RECORD
        $payment = PayrollPayment::where('person_type', $type)->where('person_id', $id)->whereDate('week_start', $weekStart)->whereDate('week_end', $weekEnd)->first();

        // ✅ SAFE DEDUCTIONS
        $deductions = [
            'advanced' => $payment ? $payment->balance_advance : 0,
            'sss' => $payment ? $payment->sss_deduction : 0,
            'pagibig' => $payment ? $payment->pagibig_deduction : 0,
            'philhealth' => $payment ? $payment->philhealth_deduction : 0,
        ];

        // ✅ SAFE NET PAY
        $netPay = $payment ? $payment->final_amount : $data['payroll_total'];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.myfile', [
            'p' => $data,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'deductions' => $deductions,
            'netPay' => $netPay,
        ]);

        return $pdf->stream($data['name'] . '-payslip.pdf');
    }

    public function getLastOdometer($plate)
    {
        $last = DB::table('expenses')->where('plate_number', $plate)->whereNotNull('odometer')->orderByDesc('date')->orderByDesc('time')->first();

        return response()->json([
            'odometer' => $last ? $last->odometer : null,
        ]);
    }

    public function updateExpense(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
            'liters' => 'required|numeric',
            'debit' => 'required|numeric',
            'start_odometer' => ['nullable', 'integer', 'min:0'],
            'odometer' => ['nullable', 'integer', 'min:0', 'gte:start_odometer'],
            'receipt_surrendered' => 'nullable|in:YES,NO',
            'remarks' => 'nullable|string',
        ]);

        DB::table('expenses')
            ->where('id', $data['id'])
            ->update([
                'liters' => $data['liters'],
                'debit' => $data['debit'],
                'start_odometer' => $data['start_odometer'],
                'odometer' => $data['odometer'],
                'receipt_surrendered' => $data['receipt_surrendered'],
                'remarks' => $data['remarks'],
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    public function complete($id)
    {
        $trip = DispatchTrip::findOrFail($id);

        $trip->billing_status = 'Billed';

        $trip->save();

        return back()->with('success', 'Trip marked as billed.');
    }

    public function updateBilling(Request $request, $id)
    {
        $trip = DispatchTrip::findOrFail($id);

        $trip->check_release_date = $request->check_release_date;
        $trip->bank_name = $request->bank_name;
        $trip->check_number = $request->check_number;

        /* If all billing details are provided → Billed, otherwise Pending */
        if ($request->filled('check_release_date') && $request->filled('bank_name') && $request->filled('check_number')) {
            $trip->billing_status = 'Billed';
        } elseif ($request->filled('check_release_date') || $request->filled('bank_name') || $request->filled('check_number')) {
            $trip->billing_status = 'Pending';
        }

        $trip->save();

        return back()->with('success', 'Billing details updated.');
    }

    public function billing(Request $request)
    {
        $q = $request->get('q');

        $sort = $request->get('sort', 'dispatch_date');
        $dir = $request->get('dir', 'desc');

        $allowedSorts = ['trip_ticket_no', 'dispatch_date', 'status', 'dispatched_at', 'id'];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'dispatch_date';
        }

        if (!in_array($dir, ['asc', 'desc'], true)) {
            $dir = 'desc';
        }

        $tripsQuery = DispatchTrip::with(['destination', 'truck', 'driver', 'helpers'])
            ->where('status', 'Completed')
            ->where(function ($q) {
                $q->whereNull('billing_status')->orWhereIn('billing_status', ['Unbilled', 'Pending']);
            });

        $checkDate = $request->get('check_date');

        if ($checkDate) {
            $tripsQuery->whereDate('check_release_date', $checkDate);
        }

        // SEARCH
        if ($q) {
            $tripsQuery->where(function ($w) use ($q) {
                $w->where('trip_ticket_no', 'like', "%{$q}%")

                    ->orWhereHas('destination', function ($d) use ($q) {
                        $d->where('store_name', 'like', "%{$q}%")->orWhere('store_code', 'like', "%{$q}%");
                    })

                    ->orWhereHas('truck', function ($t) use ($q) {
                        $t->where('plate_number', 'like', "%{$q}%");
                    })

                    ->orWhereHas('driver', function ($dr) use ($q) {
                        $dr->where('name', 'like', "%{$q}%");
                    })

                    ->orWhereHas('helpers', function ($h) use ($q) {
                        $h->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $trips = $tripsQuery->orderBy($sort, $dir)->paginate($perPage)->withQueryString();

        return view('owner.payroll.billing', compact('trips', 'q', 'sort', 'dir'));
    }

    public function updateAllowances(Request $request)
    {
        $rateFrom = $request->input('rate_from', []);
        $rateTo = $request->input('rate_to', []);
        $allowance = $request->input('allowance', []);

        // clear existing
        AllowanceRange::truncate();

        foreach ($rateFrom as $i => $from) {
            if (!$from || !isset($rateTo[$i]) || !isset($allowance[$i])) {
                continue;
            }

            AllowanceRange::create([
                'rate_from' => $from,
                'rate_to' => $rateTo[$i],
                'allowance' => $allowance[$i],
            ]);
        }

        return back()->with('success', 'Allowance rates updated.');
    }

    public function dashboard(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->toDateString() : now()->startOfWeek(Carbon::MONDAY)->toDateString();

        $to = $request->to ? Carbon::parse($request->to)->toDateString() : now()->endOfWeek(Carbon::SUNDAY)->toDateString();

        $trips = DispatchTrip::with(['destination', 'truck', 'driver', 'helpers'])
            ->where('status', 'Completed')
            ->whereDate('dispatch_date', '>=', $from)
            ->whereDate('dispatch_date', '<=', $to)
            ->get();

        $queue = collect();

        // Drivers
        $driversTrips = $trips->groupBy('driver_id');

        foreach ($driversTrips as $driverId => $group) {
            $name = optional($group->first()->driver)->name;

            $amount = $group->sum(function ($t) {
                $rate = $t->rate_snapshot ?? 0;

                $salary = $rate * 0.12;
                $allowance = $this->allowanceFromRate($rate);

                return $salary + $allowance;
            });

            $driverPaid = DB::table('payroll_payments')->where('person_type', 'driver')->where('person_id', $driverId)->whereDate('week_start', $from)->whereDate('week_end', $to)->exists();

            if ($driverPaid) {
                continue;
            }

            $queue->push([
                'person_key' => 'driver_' . $driverId,
                'person_id' => $driverId,
                'name' => $name,
                'role' => 'Driver',
                'trips' => $group->count(),
                'amount' => round($amount, 2),
                'status' => 'Pending',
            ]);
        }

        // Helpers
        $helpersTrips = collect();

        foreach ($trips as $t) {
            foreach ($t->helpers as $h) {
                $helpersTrips->push([
                    'helper_id' => $h->id,
                    'helper_name' => $h->name,
                    'trip' => $t,
                ]);
            }
        }

        $helpersGrouped = $helpersTrips->groupBy('helper_id');

        foreach ($helpersGrouped as $helperId => $items) {
            $name = $items->first()['helper_name'];

            $amount = $items->sum(function ($row) {
                $rate = $row['trip']->rate_snapshot ?? 0;

                $salary = $rate * 0.1;
                $allowance = $this->allowanceFromRate($rate);

                return $salary + $allowance;
            });

            $helperPaid = DB::table('payroll_payments')->where('person_type', 'helper')->where('person_id', $helperId)->whereDate('week_start', $from)->whereDate('week_end', $to)->exists();

            if ($helperPaid) {
                continue; // skip paid helpers
            }

            $queue->push([
                'person_key' => 'helper_' . $helperId,
                'person_id' => $helperId,
                'name' => $name,
                'role' => 'Helper',
                'trips' => $items->count(),
                'amount' => round($amount, 2),
                'status' => 'Pending',
            ]);
        }

        $pendingTrips = DispatchTrip::whereBetween('dispatch_date', [$from, $to])
            ->where('status', 'Completed')
            ->where('payment_status', '!=', 'Paid')
            ->distinct('trip_ticket_no')
            ->count('trip_ticket_no');

        $drivers = $queue->where('role', 'Driver')->count();

        $helpers = $queue->where('role', 'Helper')->count();
        $overallTotal = $queue->sum('amount');

        $ranges = AllowanceRange::orderBy('rate_from')->get();

        return view('owner.payroll.dashboard', [
            'pendingTrips' => $pendingTrips,
            'drivers' => $drivers,
            'helpers' => $helpers,
            'queue' => $queue,
            'overallTotal' => $overallTotal,
            'from' => Carbon::parse($from),
            'to' => Carbon::parse($to),
            'ranges' => $ranges, // ✅ ADD THIS
        ]);
    }

    public function finalizeWeek(Request $request)
    {
        $weekStart = $request->week_start;
        $weekEnd = $request->week_end;

        // drivers
        $drivers = \App\Models\Driver::all();

        foreach ($drivers as $driver) {
            PayrollPersonLedger::updateOrCreate(
                [
                    'week_start' => $weekStart,
                    'week_end' => $weekEnd,
                    'person_type' => 'driver',
                    'person_id' => $driver->id,
                ],
                [
                    'updated_by' => auth()->id(),
                ],
            );
        }

        // helpers
        $helpers = \App\Models\Helper::all();

        foreach ($helpers as $helper) {
            PayrollPersonLedger::updateOrCreate(
                [
                    'week_start' => $weekStart,
                    'week_end' => $weekEnd,
                    'person_type' => 'helper',
                    'person_id' => $helper->id,
                ],
                [
                    'updated_by' => auth()->id(),
                ],
            );
        }

        return redirect()->route('owner.payroll.history')->with('success', 'Payroll finalized and moved to history.');
    }

    public function show($type, $id)
    {
        $weekStart = request('from') ? Carbon::parse(request('from')) : now()->startOfWeek();

        $weekEnd = request('to') ? Carbon::parse(request('to')) : now()->endOfWeek();

        if ($type === 'driver') {
            $payroll = $this->getDriverPayroll($id, $weekStart, $weekEnd);
        } else {
            $payroll = $this->getHelperPayroll($id, $weekStart, $weekEnd);
        }

        return view('owner.payroll.show', [
            'p' => $payroll,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'type' => $type,
        ]);
    }

    private function getDriverPayroll($driverId, $weekStart, $weekEnd)
    {
        $trips = DispatchTrip::with(['destination', 'truck', 'driver'])
            ->where('status', 'Completed')
            ->whereDate('dispatch_date', '>=', $weekStart)
            ->whereDate('dispatch_date', '<=', $weekEnd)
            ->where('driver_id', $driverId)
            ->get();

        $rows = $trips->map(function ($t) {
            $rate = (float) ($t->rate_snapshot ?? 0);

            $allowance = $this->allowanceFromRate($rate);

            $amount = round($rate * 0.12, 2);

            $totalSalary = round($amount + $allowance, 2);

            return [
                'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                'location' => $t->destination->store_name ?? '-',
                'rate' => $t->rate_snapshot,
                'amount' => $amount,
                'allowance' => $allowance,
                'total_salary' => $totalSalary,
            ];
        });

        $payrollTotal = round($rows->sum('total_salary'), 2);

        $status = $trips->every(fn($t) => $t->payment_status === 'Paid') ? 'PAID' : 'UNPAID';

        return [
            'person_id' => $driverId,
            'name' => optional($trips->first()->driver)->name ?? 'Driver',
            'rows' => $rows,
            'payroll_total' => $payrollTotal,
            'status' => $status,
        ];
    }

    private function getHelperPayroll($helperId, $weekStart, $weekEnd)
    {
        $trips = DispatchTrip::with(['destination', 'truck', 'helpers'])
            ->where('status', 'Completed')
            ->whereDate('dispatch_date', '>=', $weekStart)
            ->whereDate('dispatch_date', '<=', $weekEnd)
            ->get();

        $rows = collect();

        foreach ($trips as $t) {
            foreach ($t->helpers as $h) {
                if ($h->id != $helperId) {
                    continue;
                }

                $rate = (float) ($t->rate_snapshot ?? 0);

                $allowance = $this->allowanceFromRate($rate);

                $amount = round($rate * 0.1, 2);

                $totalSalary = round($amount + $allowance, 2);

                $rows->push([
                    'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                    'location' => $t->destination->store_name ?? '-',
                    'rate' => $t->rate_snapshot,
                    'amount' => $amount,
                    'allowance' => $allowance,
                    'total_salary' => $totalSalary,
                ]);
            }
        }

        $payrollTotal = round($rows->sum('total_salary'), 2);

        $status = $trips->every(fn($t) => $t->payment_status === 'Paid') ? 'PAID' : 'UNPAID';

        return [
            'person_id' => $helperId,
            'name' => optional($trips->flatMap->helpers->firstWhere('id', $helperId))->name ?? 'Helper',
            'rows' => $rows,
            'payroll_total' => $payrollTotal,
            'status' => $status,
        ];
    }

    private function allowanceFromRate(float $rate): float
    {
        if ($rate <= 0) {
            return 0;
        }

        $range = AllowanceRange::where('rate_from', '<=', $rate)->where('rate_to', '>=', $rate)->first();

        return $range ? (float) $range->allowance : 0;
    }

    private function statusFromBalance(float $payrollTotal, float $paid, float $advance): string
    {
        if ($payrollTotal <= 0) {
            return 'NO TRIPS';
        }

        $balance = round($payrollTotal - $paid - $advance, 2);

        if ($balance <= 0 && $paid + $advance > 0) {
            return $balance < 0 ? 'OVERPAID' : 'PAID';
        }

        if ($paid + $advance > 0) {
            return 'PARTIAL';
        }

        return 'UNPAID';
    }

    private function buildKey(string $type, int $id): string
    {
        return $type . ':' . $id;
    }

    public function index(Request $request)
    {
        // default: current week Mon-Sun
        $from = $request->query('from', now()->startOfWeek(Carbon::MONDAY)->toDateString());
        $to = $request->query('to', now()->endOfWeek(Carbon::SUNDAY)->toDateString());

        // Force the "ledger week" to be Mon-Sun of the selected range
        $weekStart = Carbon::parse($from)->startOfWeek(Carbon::MONDAY);
        $weekEnd = Carbon::parse($to)->endOfWeek(Carbon::SUNDAY);

        // trips in selected range
        $trips = DispatchTrip::with(['destination', 'truck', 'driver', 'helpers'])
            ->where('status', 'Completed')
            ->whereDate('dispatch_date', '>=', $from)
            ->whereDate('dispatch_date', '<=', $to)
            ->orderBy('dispatch_date')
            ->get();

        // load ledgers for this WEEK only
        $ledgers = PayrollPersonLedger::whereDate('week_start', $weekStart->toDateString())->whereDate('week_end', $weekEnd->toDateString())->get()->keyBy(fn($l) => $this->buildKey($l->person_type, (int) $l->person_id));

        // DRIVERS
        $driversPayroll = $trips
            ->groupBy('driver_id')
            ->map(function ($group) use ($ledgers, $weekStart, $weekEnd) {
                $driverId = (int) $group->first()->driver_id;
                $name = optional($group->first()->driver)->name ?? 'Unknown Driver';

                $rows = $group->map(function ($t) {
                    $rate = (float) ($t->rate_snapshot ?? 0);

                    $allowance = $this->allowanceFromRate($rate);

                    $amount = round($rate * 0.12, 2);

                    $totalSalary = round($amount + $allowance, 2);

                    return [
                        'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                        'location' => $t->destination->store_name ?? '-',
                        'rate' => $rate,
                        'amount' => $amount,
                        'allowance' => $allowance,
                        'total_salary' => $totalSalary,
                    ];
                });

                $payrollTotal = round($rows->sum('total_salary'), 2);

                $ledger = $ledgers->get($this->buildKey('driver', $driverId));
                $paid = (float) ($ledger->paid_amount ?? 0);
                $advance = (float) ($ledger->advance_amount ?? 0);
                $balance = round($payrollTotal - $paid - $advance, 2);

                $alreadyPaid = PayrollPayment::where('person_type', 'driver')->where('person_id', $driverId)->whereDate('week_start', $weekStart)->whereDate('week_end', $weekEnd)->exists();

                $status = $alreadyPaid ? 'PAID' : 'UNPAID';

                return [
                    'week_start' => $weekStart->toDateString(),
                    'week_end' => $weekEnd->toDateString(),

                    'person_id' => $driverId,
                    'person_type' => 'driver',
                    'name' => $name,
                    'rows' => $rows,

                    'payroll_total' => $payrollTotal,
                    'paid_amount' => $paid,
                    'advance_amount' => $advance,
                    'balance' => $balance,
                    'status' => $status,
                    'notes' => $ledger->notes ?? '',
                ];
            })
            ->filter(fn($p) => $p['status'] !== 'PAID')
            ->values();

        // HELPERS (only trips with helper)
        $helpersRows = $trips->flatMap(function ($t) {
            return $t->helpers->map(function ($h) use ($t) {
                $rate = (float) ($t->rate_snapshot ?? 0);

                $allowance = $this->allowanceFromRate($rate);

                $amount = round($rate * 0.1, 2);

                $totalSalary = round($amount + $allowance, 2);

                return [
                    'helper_id' => $h->id,
                    'helper_name' => $h->name,
                    'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                    'location' => $t->destination->store_name ?? '-',
                    'rate' => $rate,
                    'amount' => $amount,
                    'allowance' => $allowance,
                    'total_salary' => $totalSalary,
                ];
            });
        });

        $helpersPayroll = $helpersRows
            ->groupBy('helper_id')
            ->map(function ($rows, $helperId) use ($ledgers, $weekStart, $weekEnd) {
                $name = $rows->first()['helper_name'] ?? 'Unknown Helper';

                $rowsOnly = $rows->map(
                    fn($r) => [
                        'date' => $r['date'],
                        'location' => $r['location'],
                        'rate' => $r['rate'],
                        'amount' => $r['amount'],
                        'allowance' => $r['allowance'],
                        'total_salary' => $r['total_salary'],
                    ],
                );

                $payrollTotal = round($rowsOnly->sum('total_salary'), 2);

                $ledger = $ledgers->get('helper:' . $helperId);
                $paid = (float) ($ledger->paid_amount ?? 0);
                $advance = (float) ($ledger->advance_amount ?? 0);
                $balance = round($payrollTotal - $paid - $advance, 2);

                $alreadyPaid = PayrollPayment::where('person_type', 'helper')->where('person_id', $helperId)->whereDate('week_start', $weekStart)->whereDate('week_end', $weekEnd)->exists();

                $status = $alreadyPaid ? 'PAID' : 'UNPAID';

                return [
                    'person_id' => (int) $helperId,
                    'name' => $name,
                    'rows' => $rowsOnly,
                    'payroll_total' => $payrollTotal,
                    'paid_amount' => $paid,
                    'advance_amount' => $advance,
                    'balance' => $balance,
                    'status' => $status,
                    'notes' => $ledger->notes ?? null,
                ];
            })
            ->filter(fn($p) => $p['status'] !== 'PAID')
            ->values();

        $driversTotal = round($driversPayroll->sum('payroll_total'), 2);
        $helpersTotal = round($helpersPayroll->sum('payroll_total'), 2);
        $grandTotal = round($driversTotal + $helpersTotal, 2);

        return view('owner.payroll.index', compact('from', 'to', 'weekStart', 'weekEnd', 'driversPayroll', 'helpersPayroll', 'driversTotal', 'helpersTotal', 'grandTotal'));
    }

    public function saveLedger(Request $request)
    {
        $data = $request->validate([
            'week_start' => 'required|date',
            'week_end' => 'required|date',
            'person_type' => 'required|in:driver,helper',
            'person_id' => 'required|integer',
            'paid_amount' => 'nullable|numeric|min:0',
            'advance_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        PayrollPersonLedger::updateOrCreate(
            [
                'week_start' => $data['week_start'],
                'person_type' => $data['person_type'],
                'person_id' => $data['person_id'],
            ],
            [
                'week_end' => $data['week_end'], // ✅ FIX: required by DB
                'paid_amount' => (float) ($data['paid_amount'] ?? 0),
                'advance_amount' => (float) ($data['advance_amount'] ?? 0),
                'notes' => $data['notes'] ?? null,
                'updated_by' => auth()->id(),
            ],
        );

        //Mail::to($person->email)->send(new PayrollReadyMail($person, $rows, $amount, $weekStart, $weekEnd));

        return back()->with('success', 'Payment/advance saved. This week will now appear in History.');
    }

    public function allowances()
    {
        $ranges = AllowanceRange::orderBy('rate_from')->get();

        return view('owner.payroll.dashboard', compact('ranges'));
    }

    public function history(Request $request)
{
    $from = $request->query('from', now()->subWeeks(8)->startOfWeek(Carbon::MONDAY)->toDateString());
    $to = $request->query('to', now()->endOfWeek(Carbon::SUNDAY)->toDateString());

    $filterStart = Carbon::parse($from)->startOfWeek(Carbon::MONDAY)->toDateString();
    $filterEnd = Carbon::parse($to)->endOfWeek(Carbon::SUNDAY)->toDateString();

    // ✅ SOURCE OF TRUTH (PAYMENTS)
    $payments = PayrollPayment::whereDate('week_start', '>=', $filterStart)
        ->whereDate('week_end', '<=', $filterEnd)
        ->orderByDesc('week_start')
        ->get();

    $weeks = $payments
        ->groupBy(fn($p) => $p->week_start . '|' . $p->week_end)
        ->map(function ($group) {

            $weekStart = $group->first()->week_start;
            $weekEnd = $group->first()->week_end;

            // 🔥 REUSE SAME PAYROLL LOGIC
            $buildRows = function ($personId, $type) use ($weekStart, $weekEnd) {

                $trips = DispatchTrip::with(['destination', 'helpers'])
                    ->where('status', 'Completed')
                    ->whereDate('dispatch_date', '>=', $weekStart)
                    ->whereDate('dispatch_date', '<=', $weekEnd)
                    ->get();

                $rows = collect();

                foreach ($trips as $t) {

                    // DRIVER
                    if ($type === 'driver' && $t->driver_id == $personId) {

                        $rate = (float) ($t->rate_snapshot ?? 0);
                        $allowance = $this->allowanceFromRate($rate);
                        $amount = round($rate * 0.12, 2);

                        $rows->push([
                            'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                            'location' => $t->destination->store_name ?? '-',
                            'rate' => $rate,
                            'amount' => $amount,
                            'allowance' => $allowance,
                            'total_salary' => $amount + $allowance,
                        ]);
                    }

                    // HELPER
                    if ($type === 'helper') {
                        foreach ($t->helpers as $h) {
                            if ($h->id != $personId) continue;

                            $rate = (float) ($t->rate_snapshot ?? 0);
                            $allowance = $this->allowanceFromRate($rate);
                            $amount = round($rate * 0.10, 2);

                            $rows->push([
                                'date' => Carbon::parse($t->dispatch_date)->format('Y-m-d'),
                                'location' => $t->destination->store_name ?? '-',
                                'rate' => $rate,
                                'amount' => $amount,
                                'allowance' => $allowance,
                                'total_salary' => $amount + $allowance,
                            ]);
                        }
                    }
                }

                return $rows;
            };

            // =========================
            // 🚛 DRIVERS
            // =========================
            $driversPayroll = $group
                ->where('person_type', 'driver')
                ->map(function ($p) use ($buildRows) {

                    $rows = $buildRows($p->person_id, 'driver');

                    $advance = (float) ($p->balance_advance ?? 0);
                    $sss = (float) ($p->sss_deduction ?? 0);
                    $philhealth = (float) ($p->philhealth_deduction ?? 0);
                    $pagibig = (float) ($p->pagibig_deduction ?? 0);

                    $totalDeduction = $advance + $sss + $philhealth + $pagibig;

                    return [
                        'person_id' => $p->person_id,
                        'person_type' => 'driver',
                        'name' => optional(\App\Models\Driver::find($p->person_id))->name ?? 'Driver',
                        'rows' => $rows,

                        'payroll_total' => $p->amount,
                        'paid_amount' => $p->final_amount,

                        // ✅ DEDUCTIONS
                        'advance' => $advance,
                        'sss' => $sss,
                        'philhealth' => $philhealth,
                        'pagibig' => $pagibig,
                        'total_deduction' => $totalDeduction,
                        'net_pay' => round(($p->amount ?? 0) - $totalDeduction, 2),

                        'status' => 'PAID',
                    ];
                })
                ->values();

            // =========================
            // 👷 HELPERS
            // =========================
            $helpersPayroll = $group
                ->where('person_type', 'helper')
                ->map(function ($p) use ($buildRows) {

                    $rows = $buildRows($p->person_id, 'helper');

                    $advance = (float) ($p->balance_advance ?? 0);
                    $sss = (float) ($p->sss_deduction ?? 0);
                    $philhealth = (float) ($p->philhealth_deduction ?? 0);
                    $pagibig = (float) ($p->pagibig_deduction ?? 0);

                    $totalDeduction = $advance + $sss + $philhealth + $pagibig;

                    return [
                        'person_id' => $p->person_id,
                        'person_type' => 'helper',
                        'name' => optional(\App\Models\Helper::find($p->person_id))->name ?? 'Helper',
                        'rows' => $rows,

                        'payroll_total' => $p->amount,
                        'paid_amount' => $p->final_amount,

                        // ✅ DEDUCTIONS
                        'advance' => $advance,
                        'sss' => $sss,
                        'philhealth' => $philhealth,
                        'pagibig' => $pagibig,
                        'total_deduction' => $totalDeduction,
                        'net_pay' => round(($p->amount ?? 0) - $totalDeduction, 2),

                        'status' => 'PAID',
                    ];
                })
                ->values();

            $driversTotal = $driversPayroll->sum('paid_amount');
            $helpersTotal = $helpersPayroll->sum('paid_amount');

            return [
                'week_start' => $weekStart,
                'week_end' => $weekEnd,
                'driversPayroll' => $driversPayroll,
                'helpersPayroll' => $helpersPayroll,
                'driversTotal' => $driversTotal,
                'helpersTotal' => $helpersTotal,
                'grandTotal' => $driversTotal + $helpersTotal,
            ];
        })
        ->values();

    return view('owner.payroll.history', compact('from', 'to', 'weeks'));
}

    public function expenses(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $expensesQuery = DB::table('expenses');
        $creditsQuery = DB::table('credits');

        if ($month && $year) {
            $expensesQuery->whereYear('date', $year)->whereMonth('date', $month);

            $creditsQuery->whereYear('date', $year)->whereMonth('date', $month);
        }

        $expenses = $expensesQuery->orderBy('plate_number')->orderBy('date')->orderBy('time')->get();

        // ✅ ADD THIS (missing mo)
        $credits = $creditsQuery->orderByDesc('id')->get();

        $totalDebit = (float) $expenses->sum('debit');
        $totalCredit = (float) $credits->sum('amount');
        $balance = $totalCredit - $totalDebit;
        $trucks = \App\Models\Truck::orderBy('plate_number')->get();

        // 🔥 COMPUTE FUEL CONSUMPTION
        $grouped = $expenses->groupBy('plate_number');

        $finalExpenses = collect();

        foreach ($grouped as $plate => $items) {
            $items = $items->sortBy('date')->values(); // ensure order

            foreach ($items as $index => $curr) {
                if ($index == 0) {
                    // first record → walang previous
                    $curr->start_odometer = $curr->odometer;
                    $curr->distance = null;
                    $curr->km_per_liter = null;
                } else {
                    $prev = $items[$index - 1];

                    if (!is_null($curr->odometer) && !is_null($prev->odometer) && $curr->liters > 0) {
                        $curr->start_odometer = $prev->odometer;

                        $distance = $curr->odometer - $prev->odometer;

                        if ($distance > 0) {
                            $curr->distance = $distance;
                            $curr->km_per_liter = round($distance / $curr->liters, 2);
                        } else {
                            $curr->distance = null;
                            $curr->km_per_liter = null;
                        }
                    } else {
                        $curr->distance = null;
                        $curr->km_per_liter = null;
                    }
                }

                $finalExpenses->push($curr);
            }
        }

        $totalDistance = 0;
        $totalLiters = 0;

        foreach ($finalExpenses as $e) {
            if (!is_null($e->distance) && $e->liters > 0) {
                $totalDistance += $e->distance;
                $totalLiters += $e->liters;
            }
        }

        $avgKmPerLiter = $totalLiters > 0 ? round($totalDistance / $totalLiters, 2) : 0;

        return view('owner.payroll.expenses', [
            'expenses' => $finalExpenses,
            'credits' => $credits,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'balance' => $balance,
            'trucks' => $trucks,
            'avgKmPerLiter' => $avgKmPerLiter,
        ]);
    }

    public function storeExpense(Request $request)
    {
        try {
            $data = $request->validate([
                'date' => ['required', 'date'],
                'time' => ['nullable', 'date_format:H:i'],
                'plate_number' => ['required', 'string', 'max:50'],
                'liters' => ['required', 'numeric', 'min:0'],
                'start_odometer' => ['nullable', 'integer', 'min:0'],
                'odometer' => ['nullable', 'integer', 'min:0'],
                'receipt_surrendered' => ['nullable', 'in:YES,NO'],
                'debit' => ['required', 'numeric', 'min:0.01'],
                'remarks' => ['nullable', 'string'],
            ]);

            if (!is_null($request->start_odometer) && !is_null($request->odometer)) {
                if ($request->odometer < $request->start_odometer) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'End odometer must be greater than start',
                        ],
                        422,
                    );
                }
            }

            $data['start_odometer'] = $data['start_odometer'] ?: null;
            $data['odometer'] = $data['odometer'] ?: null;
            $data['time'] = $data['time'] ?: null;
            $data['receipt_surrendered'] = $data['receipt_surrendered'] ?: null;
            $data['remarks'] = $data['remarks'] ?: null;

            DB::table('expenses')->insert([
                'date' => $data['date'],
                'time' => $data['time'] ?? null,
                'plate_number' => $data['plate_number'],
                'liters' => $data['liters'],
                'start_odometer' => $data['start_odometer'] ?? null,
                'odometer' => $data['odometer'] ?? null,
                'receipt_surrendered' => $data['receipt_surrendered'] ?? null,
                'debit' => $data['debit'],
                'remarks' => $data['remarks'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function storeCredit(Request $request)
    {
        try {
            $data = $request->validate([
                'amount' => ['required', 'numeric', 'min:0.01'],
                'date' => ['required', 'date'], // ✅ ADD
                'remarks' => ['nullable', 'string'],
            ]);

            DB::table('credits')->insert([
                'amount' => $data['amount'],
                'date' => $data['date'], // ✅ ADD
                'remarks' => $data['remarks'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCredit(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|integer',
                'amount' => 'required|numeric|min:0.01',
                'date' => 'required|date',
            ]);

            DB::table('credits')
                ->where('id', $data['id'])
                ->update([
                    'amount' => $data['amount'],
                    'date' => $data['date'],
                    'updated_at' => now(),
                ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function deleteCredit($id)
    {
        try {
            DB::table('credits')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function deleteExpense($id)
    {
        try {
            DB::table('expenses')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function creditsHistory()
    {
        $credits = DB::table('credits')->orderByDesc('id')->paginate(20);
        return view('owner.payroll.credits_history', compact('credits'));
    }
}
