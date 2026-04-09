<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollPayment;
use App\Models\DispatchTrip;
use Illuminate\Support\Facades\DB;

class PayrollPaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'person_type' => 'required|in:driver,helper',
            'person_id' => 'required|integer',
            'week_start' => 'required|date',
            'week_end' => 'required|date',
            'total_trips' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|string',
            'transaction_id' => 'nullable|string',
            'bonus' => 'nullable|numeric',
            'balance_advance' => 'nullable|numeric',
            'sss_deduction' => 'nullable|numeric',
            'philhealth_deduction' => 'nullable|numeric',
            'pagibig_deduction' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($data) {
            $bonus = $data['bonus'] ?? 0;
            $advance = $data['balance_advance'] ?? 0;

            $sss = $data['sss_deduction'] ?? 0;
            $philhealth = $data['philhealth_deduction'] ?? 0;
            $pagibig = $data['pagibig_deduction'] ?? 0;

            $totalDeductions = $sss + $philhealth + $pagibig;

            $finalAmount = $data['amount'] + $bonus - $advance - $totalDeductions;

            PayrollPayment::create([
                'person_type' => $data['person_type'],
                'person_id' => $data['person_id'],
                'week_start' => $data['week_start'],
                'week_end' => $data['week_end'],
                'total_trips' => $data['total_trips'],

                // original
                'amount' => $data['amount'],

                // adjustments
                'bonus' => $bonus,
                'balance_advance' => $advance,

                // deductions (NEW)
                'sss_deduction' => $sss,
                'philhealth_deduction' => $philhealth,
                'pagibig_deduction' => $pagibig,

                // final computed (VERY IMPORTANT)
                'final_amount' => $finalAmount,

                'payment_mode' => $data['payment_mode'],
                'transaction_id' => $data['transaction_id'] ?? null,
                'released_by' => auth()->id(),
                'paid_at' => now(),
            ]);

            $trips = DispatchTrip::with(['helpers', 'driver'])
                ->where('added_to_payroll', true)
                ->whereBetween('dispatch_date', [$data['week_start'], $data['week_end']])
                ->get();

            foreach ($trips as $trip) {
                $this->updateTripPaymentStatus($trip);
            }
        });

        return back()->with('success', 'Payment recorded successfully.');
    }

    private function updateTripPaymentStatus($trip)
    {
        $driverPaid = DB::table('payroll_payments')->join('payroll_payment_trips', 'payroll_payments.id', '=', 'payroll_payment_trips.payroll_payment_id')->where('dispatch_trip_id', $trip->id)->where('person_type', 'driver')->exists();

        $helperIds = $trip->helpers->pluck('id');

        $helpersPaidCount = DB::table('payroll_payments')->join('payroll_payment_trips', 'payroll_payments.id', '=', 'payroll_payment_trips.payroll_payment_id')->where('dispatch_trip_id', $trip->id)->where('person_type', 'helper')->whereIn('person_id', $helperIds)->distinct('person_id')->count('person_id');

        $helpersTotal = $helperIds->count();

        if ($driverPaid && $helpersPaidCount === $helpersTotal) {
            $trip->update([
                'payment_status' => 'Paid',
            ]);
        } else {
            $trip->update([
                'payment_status' => 'Unpaid',
            ]);
        }
    }
}
