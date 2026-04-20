<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Truck;
use App\Models\Driver;
use App\Models\Destination;
use App\Models\DispatchTrip;

class DashboardController extends Controller
{
    public function index()
    {
        // ----------------
        // BASIC STATS
        // ----------------
        $trucksStats = [
            'total' => Truck::count(),
            'active' => Truck::where('status', 'active')->count(),
        ];

        $driversStats = [
            'total' => Driver::count(),
            'active' => Driver::where('status', 'active')->count(),
        ];

        $destinationsStats = [
            'total' => Destination::count(),
            'avg_rate' => (float) (Destination::avg('rate') ?? 0),
        ];

        $tripsStats = [
            'total' => DispatchTrip::count(),
            'completed' => DispatchTrip::where('status', 'Completed')->count(),
        ];

        // ----------------
        // DATES
        // ----------------
        $today = Carbon::today();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        // ----------------
        // TODAY DATA (FIXED)
        // ----------------

        // ✅ TODAY GAINS
        $todayGains = (float) DispatchTrip::whereDate('dispatch_date', $today)
            ->whereIn('status', ['Dispatched', 'Completed'])
            ->sum('rate_snapshot');

        // ✅ TODAY FUEL
        $todayFuel = (float) DB::table('expenses')->whereDate('date', $today)->sum('debit');

        // ✅ TODAY PAYROLL
        $todayPayroll = (float) DB::table('payroll_payments')->whereDate('week_start', '<=', $today)->whereDate('week_end', '>=', $today)->sum('amount');

        // ✅ TODAY EXPENSES
        $todayExpenses = $todayFuel + $todayPayroll;

        // ✅ TODAY PROFIT
        $todayProfit = $todayGains - $todayExpenses;

        $todayData = [
            'dispatched' => DispatchTrip::whereDate('dispatch_date', $today)->where('status', 'Dispatched')->count(),

            'gains' => $todayGains,
            'profit' => $todayProfit,
        ];

        // ----------------
        // WEEK DATA
        // ----------------
        $weekData = [
            'dispatched' => DispatchTrip::whereBetween('dispatch_date', [$startWeek, $endWeek])
                ->where('status', 'Dispatched')
                ->count(),

            'gains' => (float) DispatchTrip::whereBetween('dispatch_date', [$startWeek, $endWeek])
                ->whereIn('status', ['Dispatched', 'Completed'])
                ->sum('rate_snapshot'),
        ];

        // ----------------
        // LISTS
        // ----------------
        $activeTrips = DispatchTrip::with(['destination', 'truck', 'driver'])
            ->where('status', 'Dispatched')
            ->orderByDesc('dispatch_date')
            ->take(6)
            ->get();

        $recentTrips = DispatchTrip::with(['destination'])
            ->orderByDesc('dispatch_date')
            ->take(6)
            ->get();

        $topDestinations = Destination::orderByDesc('rate')->take(6)->get();

        // ----------------
        // 🔥 FINANCIAL SUMMARY
        // ----------------

        // ✅ TOTAL GAINS
        $gains = (float) DispatchTrip::whereIn('status', ['Dispatched', 'Completed'])->sum('rate_snapshot');

        // ✅ BREAKDOWN (billing status)
        $gainsBilled = (float) DispatchTrip::where('billing_status', 'Billed')->sum('rate_snapshot');

        $gainsUnbilled = (float) DispatchTrip::where('billing_status', 'Unbilled')->sum('rate_snapshot');

        $gainsPending = (float) DispatchTrip::where('billing_status', 'Pending')->sum('rate_snapshot');

        // ✅ EXPENSES
        $fuelExpenses = (float) DB::table('expenses')->sum('debit');
        $payrollExpenses = (float) DB::table('payroll_payments')->sum('amount');

        $expenses = $fuelExpenses + $payrollExpenses;

        // ✅ PROFIT
        $profit = $gains - $expenses;

        $financialData = [
            'gains' => $gains,
            'expenses' => $expenses,
            'profit' => $profit,

            // breakdown (expenses)
            'fuel' => $fuelExpenses,
            'payroll' => $payrollExpenses,

            // breakdown (gains)
            'gains_billed' => $gainsBilled,
            'gains_unbilled' => $gainsUnbilled,
            'gains_pending' => $gainsPending,
        ];

        return view('dashboard', compact('trucksStats', 'driversStats', 'destinationsStats', 'tripsStats', 'todayData', 'weekData', 'activeTrips', 'recentTrips', 'topDestinations', 'financialData'));
    }
}
