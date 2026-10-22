@extends('layouts.admin')

@section('page_title', 'Devotee Bookings & Register')
@section('page_subtitle', 'Manage all devotee reservations, gate check-in status and guest lists')

@section('content')
<div class="space-y-6">

    <!-- Filter & Search Controls -->
    <div class="bg-white rounded-3xl p-6 border border-stone-200 shadow-xs">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-bold uppercase text-stone-500 mb-1">Search Devotee / Ref</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Name, Phone, BMA-..." 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase text-stone-500 mb-1">Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900 font-semibold">
                    <option value="">All Statuses</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $status === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase text-stone-500 mb-1">Slot Date</label>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase text-stone-500 mb-1">Holy Ghat</label>
                <select name="ghat_id" onchange="this.form.submit()" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900 font-semibold">
                    <option value="">All Ghats</option>
                    @foreach($ghats as $g)
                        <option value="{{ $g->id }}" {{ $ghatId == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2 bg-stone-900 hover:bg-black text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="py-2 px-3 text-stone-500 bg-stone-100 hover:bg-stone-200 rounded-xl text-xs font-semibold">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-stone-200 flex justify-between items-center bg-stone-50/50">
            <div>
                <h3 class="text-sm font-bold text-stone-900">Bookings List ({{ $bookings->total() }})</h3>
                <span class="text-xs text-stone-500">Filter applied results</span>
            </div>
            <a href="{{ route('admin.bookings.print', ['date' => $date ?: date('Y-m-d'), 'ghat_id' => $ghatId]) }}" target="_blank" class="px-3.5 py-1.5 text-xs font-bold text-stone-800 bg-white border border-stone-300 rounded-xl hover:bg-stone-50 shadow-xs flex items-center gap-1.5">
                <svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Print Sankalp Register</span>
            </a>
        </div>

        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Booking Ref</th>
                    <th class="px-6 py-4">Primary Devotee</th>
                    <th class="px-6 py-4">Ceremony & Ghat</th>
                    <th class="px-6 py-4">Slot Date & Time</th>
                    <th class="px-6 py-4">Devotees</th>
                    <th class="px-6 py-4">Total Amount</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($bookings as $booking)
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
                            {{ $booking->devotee_count }} ({{ ucfirst($booking->seating_type) }})
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
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-orange-600 font-bold hover:underline">
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-stone-400">
                            No bookings match your search filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-stone-200">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
