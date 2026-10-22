<?php

namespace App\Http\Controllers;

use App\Models\AartiSlot;
use App\Models\AddOn;
use App\Models\Booking;
use App\Models\BookingAddOn;
use App\Models\DevoteeDetail;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(AartiSlot $slot): View|RedirectResponse
    {
        $slot->load('aarti.ghat');

        if ($slot->is_sold_out || $slot->status !== 'active') {
            return redirect()->route('aartis.show', $slot->aarti->slug)
                ->with('error', 'This slot is already full or unavailable. Please choose another date or timing.');
        }

        $addOns = AddOn::where('is_active', true)->get();

        return view('pages.bookings.create', compact('slot', 'addOns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aarti_slot_id' => ['required', 'exists:aarti_slots,id'],
            'seating_type' => ['required', 'in:general,vip'],
            'devotee_count' => ['required', 'integer', 'min:1', 'max:10'],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email', 'max:120'],
            'contact_phone' => ['required', 'string', 'max:25'],
            'address_city' => ['nullable', 'string', 'max:100'],
            'devotees' => ['required', 'array', 'min:1'],
            'devotees.*.name' => ['required', 'string', 'max:100'],
            'devotees.*.age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'devotees.*.gender' => ['nullable', 'string', 'in:male,female,other'],
            'devotees.*.gotra' => ['nullable', 'string', 'max:60'],
            'devotees.*.sankalp_purpose' => ['nullable', 'string', 'max:150'],
            'addons' => ['nullable', 'array'],
            'payment_method' => ['required', 'string', 'in:free_pass,online_upi,card'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $booking = DB::transaction(function () use ($validated) {
            /** @var AartiSlot $slot */
            $slot = AartiSlot::where('id', $validated['aarti_slot_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $count = (int) $validated['devotee_count'];

            if ($slot->status !== 'active' || ($slot->booked_seats + $count) > $slot->total_capacity) {
                throw new \Exception('Sorry, only '.max(0, $slot->total_capacity - $slot->booked_seats).' seats left for this slot.');
            }

            // Calculate ticket price
            $ticketPricePerPerson = ($validated['seating_type'] === 'vip') ? $slot->vip_price : $slot->general_price;
            $ticketAmount = $ticketPricePerPerson * $count;

            // Calculate add-ons
            $addOnsAmount = 0;
            $selectedAddons = [];

            if (! empty($validated['addons'])) {
                foreach ($validated['addons'] as $addonId => $qty) {
                    $qty = (int) $qty;
                    if ($qty > 0) {
                        $addon = AddOn::find($addonId);
                        if ($addon) {
                            $subtotal = $addon->price * $qty;
                            $addOnsAmount += $subtotal;
                            $selectedAddons[] = [
                                'add_on_id' => $addon->id,
                                'quantity' => $qty,
                                'unit_price' => $addon->price,
                                'subtotal' => $subtotal,
                            ];
                        }
                    }
                }
            }

            $totalAmount = $ticketAmount + $addOnsAmount;
            $paymentStatus = ($totalAmount > 0) ? 'paid' : 'free';

            // Generate unique booking number
            $bookingNumber = 'BMA-'.date('Y').'-'.strtoupper(Str::random(5));
            while (Booking::where('booking_number', $bookingNumber)->exists()) {
                $bookingNumber = 'BMA-'.date('Y').'-'.strtoupper(Str::random(5));
            }

            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => Auth::id(),
                'aarti_slot_id' => $slot->id,
                'seating_type' => $validated['seating_type'],
                'devotee_count' => $count,
                'contact_name' => $validated['contact_name'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'],
                'address_city' => $validated['address_city'] ?? null,
                'ticket_amount' => $ticketAmount,
                'add_ons_amount' => $addOnsAmount,
                'total_amount' => $totalAmount,
                'payment_status' => $paymentStatus,
                'payment_method' => $validated['payment_method'],
                'payment_id' => ($totalAmount > 0) ? 'sim_pay_'.Str::random(10) : null,
                'booking_status' => 'confirmed',
                'qr_token' => Str::random(32),
                'notes' => $validated['notes'] ?? null,
            ]);

            // Save Devotee Details
            foreach ($validated['devotees'] as $devoteeData) {
                DevoteeDetail::create([
                    'booking_id' => $booking->id,
                    'name' => $devoteeData['name'],
                    'age' => $devoteeData['age'] ?? null,
                    'gender' => $devoteeData['gender'] ?? null,
                    'gotra' => $devoteeData['gotra'] ?? null,
                    'sankalp_purpose' => $devoteeData['sankalp_purpose'] ?? null,
                ]);
            }

            // Save Add-ons
            foreach ($selectedAddons as $item) {
                BookingAddOn::create([
                    'booking_id' => $booking->id,
                    'add_on_id' => $item['add_on_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Increment booked seats
            $slot->booked_seats += $count;
            if ($slot->booked_seats >= $slot->total_capacity) {
                $slot->status = 'sold_out';
            }
            $slot->save();

            return $booking;
        });

        return redirect()->route('booking.pass', $booking->booking_number)
            ->with('success', 'Jai Maa Gange! Your Aarti booking is confirmed. Your digital entry pass is ready below.');
    }

    public function pass(string $bookingNumber): View
    {
        $booking = Booking::with([
            'slot.aarti.ghat',
            'devotees',
            'bookingAddOns.addOn',
        ])
            ->where('booking_number', $bookingNumber)
            ->firstOrFail();

        return view('pages.bookings.pass', compact('booking'));
    }

    public function myBookings(Request $request): View
    {
        $search = $request->query('query');
        $bookings = collect();

        if (Auth::check()) {
            $bookings = Booking::with(['slot.aarti.ghat', 'devotees'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        if (! empty($search)) {
            $searchBookings = Booking::with(['slot.aarti.ghat', 'devotees'])
                ->where(function ($q) use ($search) {
                    $q->where('booking_number', 'like', "%{$search}%")
                        ->orWhere('contact_phone', 'like', "%{$search}%")
                        ->orWhere('contact_email', 'like', "%{$search}%");
                })
                ->latest()
                ->get();

            $bookings = $bookings->merge($searchBookings)->unique('id');
        }

        return view('pages.bookings.my-bookings', compact('bookings', 'search'));
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        if ($booking->booking_status === 'cancelled') {
            return back()->with('info', 'This booking has already been cancelled.');
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
                'cancellation_reason' => 'Devotee requested cancellation',
            ]);
        });

        return back()->with('success', 'Your Aarti pass has been cancelled successfully.');
    }
}
