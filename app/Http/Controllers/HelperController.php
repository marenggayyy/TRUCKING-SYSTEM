<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Driver;
use App\Models\Helper;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    public function index()
    {
        $helpers = Helper::orderBy('name')->get();

        $hasAvail = Schema::hasColumn(new Helper()->getTable(), 'availability_status');

        // AVAILABLE
        $availableHelpers = $helpers->filter(function ($h) {
            return $h->status === 'active' && $h->availability_status === 'available';
        });

        $onTripHelpers = $helpers->filter(function ($h) use ($hasAvail) {
            if ($hasAvail) {
                return ($h->status ?? 'active') === 'active' && ($h->availability_status ?? '') === 'on_trip';
            }
            return ($h->status ?? '') === 'on_trip';
        });

        $onLeaveHelpers = $helpers->filter(function ($h) {
            return $h->status === 'on-leave' || ($h->status === 'active' && $h->availability_status === 'on_leave');
        });

        $inactiveHelpers = $helpers->filter(function ($h) {
            return $h->status === 'inactive';
        });

        $stats = [
            'total' => $helpers->count(),
            'available' => $availableHelpers->count(),
            'on_trip_helpers' => $onTripHelpers->count(),
            'on_leave_helpers' => $onLeaveHelpers->count(),
            'inactive_helpers' => $inactiveHelpers->count(),
        ];

        return view('owner.helpers.index', compact('helpers', 'availableHelpers', 'onTripHelpers', 'onLeaveHelpers', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email|max:255|unique:helpers,email',
            'status' => 'nullable|in:active,inactive,on-leave',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email ?? null,
            'status' => $request->status ?? 'active',
        ];

        $status = $request->status ?? 'active';
        if ($status === 'inactive') {
            $data['availability_status'] = 'unavailable';
        } elseif ($status === 'on-leave') {
            $data['availability_status'] = 'on_leave';
        } else {
            $data['availability_status'] = $request->availability_status ?? 'available';
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('helpers', 'public');
        }

        if ($request->has('availability_status') && Schema::hasColumn(new Helper()->getTable(), 'availability_status')) {
            $data['availability_status'] = $request->availability_status;
        }

        Helper::create($data);

        return back()->with('success', 'Helper added.');
    }

    public function update(Request $request, Helper $helper)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:helpers,email,' . $helper->id . ',id',
            'status' => 'nullable|in:active,inactive,on-leave',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $status = $request->status ?? $helper->status;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $status,
        ];

        if ($status === 'inactive') {
            $data['availability_status'] = 'unavailable';
        } elseif ($status === 'on-leave') {
            $data['availability_status'] = 'on_leave';
        } else {
            $data['availability_status'] = $helper->availability_status;
        }

        if ($request->hasFile('profile_photo')) {
            if ($helper->profile_photo && Storage::disk('public')->exists($helper->profile_photo)) {
                Storage::disk('public')->delete($helper->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('helpers', 'public');
        }

        $helper->update($data);

        return back()->with('success', 'Helper updated.');
    }

    public function destroy(Helper $helper)
    {
        $helper->delete();
        return back()->with('success', 'Helper deleted.');
    }

   
}
