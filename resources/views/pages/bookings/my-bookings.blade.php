@extends('layouts.app')

@section('title', 'My Aarti Passes & Bookings')

@section('content')
<div class="bg-stone-900 text-white py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Devotee Passes</span>
        <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white mt-2">
            My Aarti Darshan Passes
        </h1>
        <p class="text-sm text-stone-300 mt-2 max-w-xl">
            View your active bookings, download printable E-Passes, and check gate reporting details.
        </p>

        <!-- Search / Lookup Bar -->
        <div class="mt-8 max-w-2xl bg-stone-800/90 p-4 rounded-2xl border border-stone-700">
            <form action="{{ route('my-bookings') }}" method="GET" class="flex gap-2">
                <input type="text" name="query" value="{{ $search }}" required 
                       placeholder="Enter Booking Number (e.g. BMA-2026-...) or Mobile Phone" 
                       class="flex-1 bg-stone-900 border border-stone-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-stone-500 focus:outline-hidden focus:ring-1 focus:ring-amber-500">
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-stone-950 bg-amber-400 hover:bg-amber-300 rounded-xl transition-colors">
                    Find Pass
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    @if($bookings->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-stone-200">
            <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900">No Aarti passes found</h3>
            <p class="text-xs text-stone-500 mt-1 max-w-md mx-auto">
                {{ $search ? "No bookings matched search query '{$search}'. Please verify your phone number or booking number." : "You haven't reserved any Aarti passes yet, or you are not logged in. You can search by your mobile number above." }}
            </p>
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('aartis.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-orange-600 rounded-xl hover:bg-orange-700 transition-colors">
                    Browse Aarti Ceremonies
                </a>
                @guest
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-xs font-bold text-stone-700 bg-stone-100 rounded-xl hover:bg-stone-200 transition-colors">
                        Sign In with Account
                    </a>
                @endguest
            </div>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-md hover:shadow-lg transition-all flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-xs font-bold bg-stone-100 text-stone-800 px-3 py-1 rounded-lg">
                                {{ $booking->booking_number }}
                            </span>
                            @if($booking->booking_status === 'confirmed')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    Confirmed
                                </span>
                            @elseif($booking->booking_status === 'checked_in')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                    Checked In
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                    Cancelled
                                </span>
                            @endif
                            <span class="text-xs font-semibold uppercase text-stone-400">
                                {{ $booking->seating_type }} Seating
                            </span>
                        </div>

                        <div>
                            <h3 class="font-cinzel text-xl font-bold text-stone-900">
                                {{ $booking->slot->aarti->title }}
                            </h3>
                            <p class="text-xs text-orange-600 font-semibold mt-0.5">
                                📍 {{ $booking->slot->aarti->ghat->name }}, {{ $booking->slot->aarti->ghat->city }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-xs text-stone-500">
                            <span>📅 {{ $booking->slot->slot_date->format('d M Y') }}</span>
                            <span>⏰ {{ $booking->slot->formatted_time }}</span>
                            <span>👥 {{ $booking->devotee_count }} Devotee(s)</span>
                            <span>💵 {{ $booking->total_amount > 0 ? '₹' . number_format($booking->total_amount, 0) : 'Free Pass' }}</span>
                        </div>
                    </div>

                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-3 border-t md:border-t-0 pt-4 md:pt-0 border-stone-100">
                        <a href="{{ route('booking.pass', $booking->booking_number) }}" class="px-5 py-2.5 text-xs font-bold text-white bg-stone-900 hover:bg-orange-600 rounded-xl transition-colors shadow-xs flex items-center gap-2">
                            <span>View / Print Pass</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>

                        @if($booking->booking_status === 'confirmed')
                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this pass?')">
                                @csrf
                                <button type="submit" class="text-[11px] text-rose-600 hover:underline">
                                    Cancel Pass
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
