<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollPayment;
use App\Models\DispatchTrip;
use App\Models\PayrollPersonLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'advance_amount' => 'nullable|numeric|min:0',
            'balance_advance' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {

            $newAdvance = (float) ($data['advance_amount'] ?? 0);
            $advanceDeducted = (float) ($data['balance_advance'] ?? 0);

            /*
            |--------------------------------------------------------------------------
            | PREVENT DUPLICATE PAYROLL
            |--------------------------------------------------------------------------
            */
            $existing = PayrollPayment::where([
                'person_type' => $data['person_type'],
                'person_id' => $data['person_id'],
                'week_start' => $data['week_start'],
                'week_end' => $data['week_end'],
            ])->exists();

            if ($existing) {
                throw ValidationException::withMessages([
                    'person_id' => 'Payroll already paid for this week.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | FIND / CREATE LEDGER
            |--------------------------------------------------------------------------
            */
            $ledger = PayrollPersonLedger::firstOrCreate(
                [
                    'person_type' => $data['person_type'],
                    'person_id' => $data['person_id'],
                    'week_start' => $data['week_start'],
                    'week_end' => $data['week_end'],
                ],
                [
                    'paid_amount' => 0,
                    'advance_amount' => 0,
                    'notes' => null,
                    'updated_by' => Auth::id(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | APPLY NEW ADVANCE FIRST
            |--------------------------------------------------------------------------
            */
            $ledger->advance_amount += $newAdvance;

            /*
            |--------------------------------------------------------------------------
            | VALIDATE DEDUCTION
            |--------------------------------------------------------------------------
            */
            if ($advanceDeducted > $ledger->advance_amount) {
                throw ValidationException::withMessages([
                    'balance_advance' => 'Advance deduction cannot exceed remaining advance balance.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | COMPUTE FINAL PAY
            |--------------------------------------------------------------------------
            */
            $finalAmount = max(0, $data['amount'] - $advanceDeducted);

            /*
            |--------------------------------------------------------------------------
            | UPDATE LEDGER
            |--------------------------------------------------------------------------
            */
            $ledger->advance_amount -= $advanceDeducted;
            $ledger->paid_amount += $finalAmount;
            $ledger->updated_by = Auth::id();
            $ledger->save();

            /*
            |--------------------------------------------------------------------------
            | CREATE PAYMENT RECORD
            |--------------------------------------------------------------------------
            */
            $payment = PayrollPayment::create([
                'person_type' => $data['person_type'],
                'person_id' => $data['person_id'],
                'week_start' => $data['week_start'],
                'week_end' => $data['week_end'],
                'total_trips' => $data['total_trips'],
                'amount' => $data['amount'],
                'balance_advance' => $advanceDeducted,
                'final_amount' => $finalAmount,
                'payment_mode' => $data['payment_mode'],
                'transaction_id' => $data['transaction_id'] ?? null,
                'released_by' => Auth::id(),
                'paid_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | LINK TRIPS TO PAYMENT
            |--------------------------------------------------------------------------
            */
            $trips = DispatchTrip::with(['helpers'])
                ->where('status', 'Completed')
                ->whereBetween('dispatch_date', [
                    $data['week_start'],
                    $data['week_end']
                ])
                ->get();

            foreach ($trips as $trip) {

                if (
                    $data['person_type'] === 'driver' &&
                    $trip->driver_id == $data['person_id']
                ) {
                    DB::table('payroll_payment_trips')->insert([
                        'payroll_payment_id' => $payment->id,
                        'dispatch_trip_id' => $trip->id,
                    ]);
                }

                if ($data['person_type'] === 'helper') {
                    foreach ($trip->helpers as $h) {
                        if ($h->id == $data['person_id']) {
                            DB::table('payroll_payment_trips')->insert([
                                'payroll_payment_id' => $payment->id,
                                'dispatch_trip_id' => $trip->id,
                            ]);
                        }
                    }
                }

                $this->updateTripPaymentStatus($trip);
            }
        });

        return back()->with('success', 'Payment recorded successfully.');
    }

    private function updateTripPaymentStatus($trip)
    {
        $driverPaid = DB::table('payroll_payments')
            ->join(
                'payroll_payment_trips',
                'payroll_payments.id',
                '=',
                'payroll_payment_trips.payroll_payment_id'
            )
            ->where('dispatch_trip_id', $trip->id)
            ->where('person_type', 'driver')
            ->exists();

        $helperIds = $trip->helpers->pluck('id');

        $helpersPaidCount = DB::table('payroll_payments')
            ->join(
                'payroll_payment_trips',
                'payroll_payments.id',
                '=',
                'payroll_payment_trips.payroll_payment_id'
            )
            ->where('dispatch_trip_id', $trip->id)
            ->where('person_type', 'helper')
            ->whereIn('person_id', $helperIds)
            ->distinct()
            ->count('person_id');

        $helpersTotal = $helperIds->count();

        $trip->update([
            'payment_status' =>
                ($driverPaid && $helpersPaidCount === $helpersTotal)
                    ? 'Paid'
                    : 'Unpaid',
        ]);
    }
}