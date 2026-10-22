@extends('layouts.admin')

@section('page_title', 'Booking: ' . $booking->booking_number)
@section('page_subtitle', 'Devotee attendee details, Sankalp prayers and gate verification status')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Top Action Ribbon -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-stone-600 hover:text-stone-900">
            &larr; Back to All Bookings
        </a>

        <div class="flex items-center gap-3">
            @if($booking->booking_status === 'confirmed')
                <form action="{{ route('admin.bookings.attended', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                        ✓ Mark Checked-In at Gate
                    </button>
                </form>

                <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking and release seats back to the slot?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition-colors">
                        Cancel Booking
                    </button>
                </form>
            @endif

            <a href="{{ route('booking.pass', $booking->booking_number) }}" target="_blank" class="px-4 py-2 text-xs font-bold text-stone-900 bg-white border border-stone-300 rounded-xl hover:bg-stone-50 shadow-xs">
                View Public Pass
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs p-8 space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-6 border-b border-stone-200 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-orange-600">Booking Reference</span>
                <h1 class="font-mono text-2xl font-black text-stone-900 mt-0.5">{{ $booking->booking_number }}</h1>
                <p class="text-xs text-stone-500 mt-1">Booked on {{ $booking->created_at->format('d M Y, h:i A') }}</p>
            </div>

            <div class="flex items-center gap-2">
                @if($booking->booking_status === 'confirmed')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Confirmed (Valid)</span>
                @elseif($booking->booking_status === 'checked_in')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Gate Checked-In</span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Cancelled</span>
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-stone-100 text-stone-800 uppercase">{{ $booking->seating_type }} SEATING</span>
            </div>
        </div>

        <!-- Ceremony & Slot Details -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 bg-stone-50 p-6 rounded-2xl border border-stone-200 text-xs">
            <div>
                <span class="text-stone-400 font-semibold block">Aarti Ceremony</span>
                <span class="font-bold text-stone-900 text-sm mt-0.5 block">{{ $booking->slot->aarti->title }}</span>
                <span class="text-stone-500">{{ $booking->slot->aarti->ghat->name }}, {{ $booking->slot->aarti->ghat->city }}</span>
            </div>
            <div>
                <span class="text-stone-400 font-semibold block">Date & Slot</span>
                <span class="font-bold text-stone-900 text-sm mt-0.5 block">{{ $booking->slot->slot_date->format('d M Y') }}</span>
                <span class="text-stone-500">{{ $booking->slot->formatted_time }}</span>
            </div>
            <div>
                <span class="text-stone-400 font-semibold block">Contact Devotee</span>
                <span class="font-bold text-stone-900 text-sm mt-0.5 block">{{ $booking->contact_name }}</span>
                <span class="text-stone-500">{{ $booking->contact_phone }} • {{ $booking->contact_email }}</span>
            </div>
        </div>

        <!-- Devotees & Sankalp Prayers Table -->
        <div>
            <h3 class="text-sm font-bold text-stone-900 uppercase tracking-wider mb-4">
                Devotees & Sankalp Register ({{ $booking->devotee_count }})
            </h3>
            <div class="border border-stone-200 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Devotee Name</th>
                            <th class="px-4 py-3">Age / Gender</th>
                            <th class="px-4 py-3">Gotra</th>
                            <th class="px-4 py-3">Sankalp Prayer Intention</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($booking->devotees as $index => $devotee)
                            <tr>
                                <td class="px-4 py-3 font-bold text-stone-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-bold text-stone-900">{{ $devotee->name }}</td>
                                <td class="px-4 py-3 text-stone-600">
                                    {{ $devotee->age ? $devotee->age . ' yrs' : 'N/A' }} / {{ ucfirst($devotee->gender ?? 'N/A') }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-stone-800">
                                    {{ $devotee->gotra ?: 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-stone-600 italic">
                                    {{ $devotee->sankalp_purpose ?: 'General Aarti Darshan' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offerings & Payment breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-stone-200 text-xs">
            <div>
                <h4 class="font-bold text-stone-900 mb-2">Sanctified Offerings / Add-Ons:</h4>
                @if($booking->bookingAddOns->isNotEmpty())
                    <ul class="space-y-1.5 text-stone-700">
                        @foreach($booking->bookingAddOns as $item)
                            <li class="flex justify-between border-b border-stone-100 pb-1">
                                <span>🪔 {{ $item->addOn->name }} (&times; {{ $item->quantity }})</span>
                                <span class="font-bold">₹{{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-stone-400">No add-on offerings purchased.</span>
                @endif
            </div>

            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200 space-y-2">
                <div class="flex justify-between">
                    <span class="text-stone-500">Ticket Fees:</span>
                    <span class="font-bold">₹{{ number_format($booking->ticket_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Add-ons Subtotal:</span>
                    <span class="font-bold">₹{{ number_format($booking->add_ons_amount, 2) }}</span>
                </div>
                <div class="pt-2 border-t border-stone-200 flex justify-between text-sm font-bold text-stone-900">
                    <span>Total Paid:</span>
                    <span class="text-orange-600">₹{{ number_format($booking->total_amount, 2) }}</span>
                </div>
                <div class="text-[11px] text-stone-500 pt-1">
                    Payment Method: <span class="font-semibold uppercase text-stone-700">{{ $booking->payment_method }}</span>
                    @if($booking->payment_id)
                        • ID: {{ $booking->payment_id }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
