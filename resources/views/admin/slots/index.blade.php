@extends('layouts.admin')

@section('page_title', 'Slots & Capacity Scheduler')
@section('page_subtitle', 'Configure daily quotas, start times, and batch generate schedules')

@section('content')
<div class="space-y-6">
    <!-- Top Action Ribbon -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Date & Aarti Filter Form -->
        <form action="{{ route('admin.slots.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <div>
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" 
                       class="bg-white border border-stone-300 rounded-xl px-3 py-2 text-xs font-bold text-stone-800 shadow-xs">
            </div>

            <div>
                <select name="aarti_id" onchange="this.form.submit()" class="bg-white border border-stone-300 rounded-xl px-3 py-2 text-xs font-bold text-stone-800 shadow-xs">
                    <option value="">All Ceremonies</option>
                    @foreach($aartis as $aarti)
                        <option value="{{ $aarti->id }}" {{ $aartiId == $aarti->id ? 'selected' : '' }}>
                            {{ $aarti->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('admin.slots.index') }}" class="px-3 py-2 text-xs font-semibold text-stone-500 hover:text-stone-800 bg-stone-200/80 rounded-xl">
                Reset
            </a>
        </form>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.slots.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-colors shadow-xs">
                + Create / Batch Slots
            </a>
        </div>
    </div>

    <!-- Slots Table -->
    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-stone-200 flex justify-between items-center bg-stone-50/50">
            <div>
                <h3 class="text-sm font-bold text-stone-900">
                    Slots for: {{ $date ? Carbon\Carbon::parse($date)->format('D, d M Y') : 'All Dates' }}
                </h3>
                <span class="text-xs text-stone-500">{{ $slots->total() }} scheduled ritual slots</span>
            </div>
        </div>

        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Slot Date & Time</th>
                    <th class="px-6 py-4">Ceremony & Ghat</th>
                    <th class="px-6 py-4">Booked / Capacity</th>
                    <th class="px-6 py-4">Seat Availability</th>
                    <th class="px-6 py-4">Pricing</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($slots as $slot)
                    @php
                        $percentage = min(100, round(($slot->booked_seats / max(1, $slot->total_capacity)) * 100));
                    @endphp
                    <tr class="hover:bg-stone-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-stone-900 text-sm">{{ $slot->formatted_time }}</div>
                            <div class="text-[11px] text-stone-500">{{ $slot->slot_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-stone-900">{{ $slot->aarti->title }}</div>
                            <div class="text-[11px] text-stone-500">{{ $slot->aarti->ghat->name }} ({{ $slot->aarti->ghat->city }})</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-stone-800">{{ $slot->booked_seats }} / {{ $slot->total_capacity }} seats</div>
                            <div class="w-32 h-1.5 rounded-full bg-stone-200 mt-1 overflow-hidden">
                                <div class="h-full rounded-full {{ $percentage > 85 ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $percentage }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold">
                            @if($slot->available_seats <= 0)
                                <span class="text-rose-600 font-extrabold">0 seats (FULL)</span>
                            @else
                                <span class="text-emerald-700">{{ $slot->available_seats }} seats available</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-stone-600">
                            <div>General: {{ $slot->general_price == 0 ? 'Free' : '₹' . number_format($slot->general_price, 0) }}</div>
                            <div class="text-[11px] text-orange-600 font-bold">VIP: ₹{{ number_format($slot->vip_price, 0) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($slot->status === 'active')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                            @elseif($slot->status === 'sold_out')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Sold Out</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.slots.edit', $slot->id) }}" class="text-orange-600 font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this slot?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-stone-400">
                            No slots found for this date. Click "+ Create / Batch Slots" to generate.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-stone-200">
            {{ $slots->links() }}
        </div>
    </div>
</div>
@endsection
