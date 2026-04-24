<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollPayment;
use App\Models\DispatchTrip;
use App\Models\PayrollPersonLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\FlashTrip;
use App\Models\FlashPayrollPayment;

class FlashPayrollPaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'person_id' => 'required|integer',
            'week_start' => 'required|date',
            'week_end' => 'required|date',
            'total_trips' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|string',
            'transaction_id' => 'nullable|string',
            'balance_advance' => 'nullable|numeric|min:0',
            'advance_deducted' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($data) {
            // ✅ prevent duplicate
            $exists = FlashPayrollPayment::where([
                'driver_id' => $data['person_id'],
                'week_start' => $data['week_start'],
                'week_end' => $data['week_end'],
            ])->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'person_id' => 'Already paid for this week.',
                ]);
            }

            $advance = (float) ($data['balance_advance'] ?? 0);
            $deduct = (float) ($data['advance_deducted'] ?? 0);

            if ($deduct > $advance) {
                throw ValidationException::withMessages([
                    'advance_deducted' => 'Invalid deduction.',
                ]);
            }

            $remaining = max($advance - $deduct, 0);
            $final = max(0, $data['amount'] - $deduct);

            // ✅ create payment
            $payment = FlashPayrollPayment::create([
                'driver_id' => $data['person_id'],
                'week_start' => $data['week_start'],
                'week_end' => $data['week_end'],
                'total_trips' => $data['total_trips'],
                'amount' => $data['amount'],
                'advance_amount' => $advance,
                'advance_deducted' => $deduct,
                'balance_advance' => $remaining,
                'final_amount' => $final,
                'payment_mode' => $data['payment_mode'],
                'transaction_id' => $data['transaction_id'],
                'paid_at' => now(),
            ]);

            // ✅ link trips
            $trips = FlashTrip::where('driver_id', $data['person_id'])
                ->where('status', 'Completed')
                ->whereBetween('dispatch_date', [$data['week_start'], $data['week_end']])
                ->get();

            foreach ($trips as $trip) {
                DB::table('flash_payroll_payment_trips')->insert([
                    'flash_payroll_payment_id' => $payment->id,
                    'flash_trip_id' => $trip->id,
                ]);

                // optional: mark paid
                $trip->update(['payment_status' => 'Paid']);
            }
        });

        return back()->with('success', 'Flash payroll paid!');
    }

    private function updateTripPaymentStatus($trip)
    {
        $driverPaid = DB::table('payroll_payments')->join('payroll_payment_trips', 'payroll_payments.id', '=', 'payroll_payment_trips.payroll_payment_id')->where('dispatch_trip_id', $trip->id)->where('person_type', 'driver')->exists();

        $helperIds = $trip->helpers->pluck('id');

        $helpersPaidCount = DB::table('payroll_payments')->join('payroll_payment_trips', 'payroll_payments.id', '=', 'payroll_payment_trips.payroll_payment_id')->where('dispatch_trip_id', $trip->id)->where('person_type', 'helper')->whereIn('person_id', $helperIds)->distinct()->count('person_id');

        $helpersTotal = $helperIds->count();

        $trip->update([
            'payment_status' => $driverPaid && $helpersPaidCount === $helpersTotal ? 'Paid' : 'Unpaid',
        ]);
    }
}
