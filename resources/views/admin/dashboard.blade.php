@extends('layouts.admin')

@section('page_title', 'Administrative Overview')
@section('page_subtitle', 'Live Ghat Operations, Aarti Bookings & Footfall')

@section('content')
<div class="space-y-8">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Metric 1: Today's Bookings -->
        <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Today's Bookings</span>
                <div class="text-3xl font-extrabold text-stone-900 mt-1">{{ number_format($todayBookings) }}</div>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-block">Active pass holders</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
        </div>

        <!-- Metric 2: Today's Total Devotees -->
        <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Devotees Today</span>
                <div class="text-3xl font-extrabold text-stone-900 mt-1">{{ number_format($todayDevotees) }}</div>
                <span class="text-[11px] text-stone-500 font-semibold mt-1 inline-block">Expected at Ghats</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- Metric 3: Total Collections / Donations -->
        <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Total Seva Donations</span>
                <div class="text-3xl font-extrabold text-stone-900 mt-1">₹{{ number_format($totalRevenue, 0) }}</div>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-block">VIP & Offerings</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Metric 4: Active Ghats & Ceremonies -->
        <div class="bg-white p-6 rounded-3xl border border-stone-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Sanctuaries</span>
                <div class="text-3xl font-extrabold text-stone-900 mt-1">{{ $totalGhats }} Ghats</div>
                <span class="text-[11px] text-stone-500 font-semibold mt-1 inline-block">{{ $totalAartis }} Aarti Ceremonies</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-stone-100 text-stone-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
    </div>

    <!-- Quick Action Ribbon -->
    <div class="bg-gradient-to-r from-stone-900 via-stone-850 to-stone-900 text-white rounded-3xl p-6 shadow-md flex flex-wrap items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <span>⚡ Operations Fast-Track</span>
            </h3>
            <p class="text-xs text-stone-400 mt-0.5">Quick administrative shortcuts for today's ghat operations.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.check-in.index') }}" class="px-4 py-2 text-xs font-bold text-stone-950 bg-amber-400 hover:bg-amber-300 rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                <span>Gate Pass Scanner</span>
            </a>
            <a href="{{ route('admin.bookings.print') }}" target="_blank" class="px-4 py-2 text-xs font-bold text-white bg-stone-800 hover:bg-stone-700 rounded-xl transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Print Sankalp Register</span>
            </a>
            <a href="{{ route('admin.slots.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-all">
                + Create Slot
            </a>
        </div>
    </div>

    <!-- Today's Slot Capacities -->
    <div class="bg-white rounded-3xl border border-stone-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-bold text-stone-900">Today's Aarti Slots Status ({{ date('d M Y') }})</h2>
                <p class="text-xs text-stone-500">Live capacity utilization per ceremony for tonight's rituals.</p>
            </div>
            <a href="{{ route('admin.slots.index') }}" class="text-xs font-bold text-orange-600 hover:underline">
                View Full Calendar &rarr;
            </a>
        </div>

        @if($todaySlots->isEmpty())
            <div class="text-center py-8 text-stone-500 text-xs">
                No slots configured for today. Use the Slots manager to generate daily schedules.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($todaySlots as $slot)
                    @php
                        $percentage = min(100, round(($slot->booked_seats / max(1, $slot->total_capacity)) * 100));
                    @endphp
                    <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200/80 space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold uppercase text-stone-500">{{ $slot->aarti->ghat->city }}</span>
                                <h3 class="text-xs font-bold text-stone-900 line-clamp-1">{{ $slot->aarti->title }}</h3>
                            </div>
                            <span class="text-[11px] font-mono font-bold text-stone-700">{{ $slot->formatted_time }}</span>
                        </div>

                        <!-- Progress Bar -->
                        <div>
                            <div class="flex justify-between text-[11px] font-semibold mb-1">
                                <span class="text-stone-600">{{ $slot->booked_seats }} / {{ $slot->total_capacity }} booked</span>
                                <span class="{{ $percentage > 85 ? 'text-rose-600' : 'text-stone-900' }}">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-stone-200 overflow-hidden">
                                <div class="h-full rounded-full {{ $percentage > 85 ? 'bg-rose-500' : ($percentage > 50 ? 'bg-amber-500' : 'bg-emerald-500') }}" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-stone-200 flex justify-between items-center text-[11px]">
                            <span class="text-stone-500">{{ $slot->available_seats }} available</span>
                            <a href="{{ route('admin.slots.edit', $slot->id) }}" class="font-bold text-orange-600 hover:underline">Manage</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-stone-200 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-stone-900">Recent Devotee Bookings</h2>
                <p class="text-xs text-stone-500">Live reservations received from devotees across India.</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-orange-600 hover:underline">
                View All Bookings &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Booking Ref</th>
                        <th class="px-6 py-4">Devotee Name</th>
                        <th class="px-6 py-4">Ceremony & Ghat</th>
                        <th class="px-6 py-4">Slot Date & Time</th>
                        <th class="px-6 py-4">Devotees</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-stone-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-stone-900">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="hover:text-orange-600 underline">
                                    {{ $booking->booking_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-stone-900">{{ $booking->contact_name }}</div>
                                <div class="text-[11px] text-stone-500">{{ $booking->contact_phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-stone-900">{{ $booking->slot->aarti->title }}</div>
                                <div class="text-[11px] text-stone-500">{{ $booking->slot->aarti->ghat->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-stone-600">
                                <div>{{ $booking->slot->slot_date->format('d M Y') }}</div>
                                <div class="text-[11px] text-stone-400">{{ $booking->slot->formatted_time }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-stone-900">
                                {{ $booking->devotee_count }}
                            </td>
                            <td class="px-6 py-4 font-bold text-stone-900">
                                {{ $booking->total_amount > 0 ? '₹' . number_format($booking->total_amount, 0) : 'Free' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->booking_status === 'confirmed')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Confirmed</span>
                                @elseif($booking->booking_status === 'checked_in')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Checked In</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-stone-700 hover:text-orange-600 font-bold">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-stone-400">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
