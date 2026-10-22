<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ghat;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $date = $request->query('date');
        $ghatId = $request->query('ghat_id');
        $search = $request->query('search');

        $query = Booking::with(['slot.aarti.ghat', 'devotees'])
            ->latest();

        if (! empty($status)) {
            $query->where('booking_status', $status);
        }

        if (! empty($date)) {
            $query->whereHas('slot', function ($q) use ($date) {
                $q->where('slot_date', $date);
            });
        }

        if (! empty($ghatId)) {
            $query->whereHas('slot.aarti', function ($q) use ($ghatId) {
                $q->where('ghat_id', $ghatId);
            });
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('contact_phone', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(20);
        $ghats = Ghat::where('is_active', true)->get();

        return view('admin.bookings.index', compact('bookings', 'ghats', 'status', 'date', 'ghatId', 'search'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['slot.aarti.ghat', 'devotees', 'bookingAddOns.addOn', 'user']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function markAttended(Booking $booking): RedirectResponse
    {
        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'Cannot check in a cancelled booking.');
        }

        $booking->update([
            'booking_status' => 'checked_in',
            'checked_in_at' => Carbon::now(),
        ]);

        return back()->with('success', "Devotee marked as Checked-In for booking {$booking->booking_number}.");
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        if ($booking->booking_status === 'cancelled') {
            return back()->with('info', 'Booking is already cancelled.');
        }

        DB::transaction(function () use ($booking) {
            $slot = $booking->slot()->lockForUpdate()->first();
            if ($slot) {
                $slot->booked_seats = max(0, $slot->booked_seats - $booking->devotee_count);
                if ($slot->status === 'sold_out') {
                    $slot->status = 'active';
                }
                $slot->save();
            }

            $booking->update([
                'booking_status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
                'cancellation_reason' => 'Admin cancelled booking',
            ]);
        });

        return back()->with('success', "Booking {$booking->booking_number} cancelled and quota restored.");
    }

    public function printRegister(Request $request): View
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        $ghatId = $request->query('ghat_id');

        $query = Booking::with(['slot.aarti.ghat', 'devotees', 'bookingAddOns.addOn'])
            ->whereHas('slot', function ($q) use ($date) {
                $q->where('slot_date', $date);
            })
            ->where('booking_status', '!=', 'cancelled')
            ->orderBy('seating_type', 'desc');

        if (! empty($ghatId)) {
            $query->whereHas('slot.aarti', function ($q) use ($ghatId) {
                $q->where('ghat_id', $ghatId);
            });
        }

        $bookings = $query->get();
        $ghat = $ghatId ? Ghat::find($ghatId) : null;

        return view('admin.bookings.print-register', compact('bookings', 'date', 'ghat'));
    }
}
