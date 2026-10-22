@extends('layouts.admin')

@section('page_title', 'Edit Slot: ' . $slot->aarti->title)
@section('page_subtitle', 'Adjust date, capacities or override pricing for this slot')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.slots.update', $slot->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-stone-50 p-4 rounded-2xl border border-stone-200 text-xs">
                <span class="font-bold text-stone-900">{{ $slot->aarti->title }}</span>
                <span class="block text-stone-500">{{ $slot->aarti->ghat->name }} ({{ $slot->aarti->ghat->city }})</span>
                <span class="block text-orange-600 font-bold mt-1">Currently Booked: {{ $slot->booked_seats }} devotees</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Slot Date *</label>
                <input type="date" name="slot_date" required value="{{ old('slot_date', $slot->slot_date->format('Y-m-d')) }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Start Time *</label>
                    <input type="time" name="start_time" required value="{{ old('start_time', Carbon\Carbon::parse($slot->start_time)->format('H:i')) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">End Time *</label>
                    <input type="time" name="end_time" required value="{{ old('end_time', Carbon\Carbon::parse($slot->end_time)->format('H:i')) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Total Capacity *</label>
                    <input type="number" name="total_capacity" required value="{{ old('total_capacity', $slot->total_capacity) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">General (₹) *</label>
                    <input type="number" name="general_price" required value="{{ old('general_price', $slot->general_price) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">VIP (₹) *</label>
                    <input type="number" name="vip_price" required value="{{ old('vip_price', $slot->vip_price) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Slot Status *</label>
                    <select name="status" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                        <option value="active" {{ $slot->status === 'active' ? 'selected' : '' }}>Active (Available)</option>
                        <option value="sold_out" {{ $slot->status === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                        <option value="cancelled" {{ $slot->status === 'cancelled' ? 'selected' : '' }}>Cancelled / Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Reporting Note</label>
                    <input type="text" name="reporting_time" value="{{ old('reporting_time', $slot->reporting_time) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Update Slot
                </button>
                <a href="{{ route('admin.slots.index', ['date' => $slot->slot_date->format('Y-m-d')]) }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
