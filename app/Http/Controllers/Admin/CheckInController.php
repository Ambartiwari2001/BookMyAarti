<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->query('code');
        $booking = null;
        $error = null;

        if (! empty($query)) {
            $booking = Booking::with(['slot.aarti.ghat', 'devotees', 'bookingAddOns.addOn'])
                ->where('qr_token', $query)
                ->orWhere('booking_number', strtoupper(trim($query)))
                ->first();

            if (! $booking) {
                $error = "No booking found matching code '{$query}'. Please verify ticket reference.";
            }
        }

        return view('admin.check-in.index', compact('booking', 'query', 'error'));
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'Alert: This booking has been CANCELLED and cannot be admitted.');
        }

        if ($booking->booking_status === 'checked_in') {
            return back()->with('warning', 'Notice: This pass was ALREADY CHECKED IN at '.$booking->checked_in_at->format('h:i A').'.');
        }

        $booking->update([
            'booking_status' => 'checked_in',
            'checked_in_at' => Carbon::now(),
        ]);

        return back()->with('success', "✓ Gate Check-In Successful! Welcome {$booking->contact_name} ({$booking->devotee_count} Devotees).");
    }
}
