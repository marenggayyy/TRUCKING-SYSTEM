<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'total'  => Truck::count(),
            'active' => Truck::where('status', 'active')->count(),
        ];

        $driversStats = [
            'total'  => Driver::count(),
            'active' => Driver::where('status', 'active')->count(),
        ];

        $destinationsStats = [
            'total'    => Destination::count(),
            'avg_rate' => (float) (Destination::avg('rate') ?? 0),
        ];

        $tripsStats = [
            'total'     => DispatchTrip::count(),
            'completed' => DispatchTrip::where('status', 'Completed')->count(),
        ];

        // ----------------
        // DATES
        // ----------------
        $today = Carbon::today();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        // ----------------
        // TODAY DATA
        // Gains = sum(rate_snapshot)
        // ----------------
        $todayData = [
            'dispatched' => DispatchTrip::whereDate('dispatch_date', $today)
                ->where('status', 'Dispatched')
                ->count(),

            'gains' => (float) DispatchTrip::whereDate('dispatch_date', $today)
                ->whereIn('status', ['Dispatched', 'Completed']) // optional: include completed too
                ->sum('rate_snapshot'),

            // No profit column in dispatch_trips
            'profit' => 0,
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
            ->whereIn('status', ['Dispatched']) // or add more statuses if you have
            ->orderByDesc('dispatch_date')
            ->take(6)
            ->get();

        $recentTrips = DispatchTrip::with(['destination'])
            ->orderByDesc('dispatch_date')
            ->take(6)
            ->get();

        $topDestinations = Destination::orderByDesc('rate')
            ->take(6)
            ->get();

        // ----------------
        // FINANCIAL SUMMARY
        // Gains = sum(rate_snapshot)
        // ----------------
        $financialData = [
            'gains' => (float) DispatchTrip::whereIn('status', ['Dispatched', 'Completed'])->sum('rate_snapshot'),
            'expenses' => 0, // add when you have expenses table
            'profit' => 0,   // add when you can compute profit
        ];

        return view('dashboard', compact(
            'trucksStats',
            'driversStats',
            'destinationsStats',
            'tripsStats',
            'todayData',
            'weekData',
            'activeTrips',
            'recentTrips',
            'topDestinations',
            'financialData'
        ));
    }
}
