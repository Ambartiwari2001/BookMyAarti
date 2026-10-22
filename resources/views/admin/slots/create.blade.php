@extends('layouts.admin')

@section('page_title', 'Create / Generate Aarti Slots')
@section('page_subtitle', 'Generate single slots or batch generate upcoming schedules')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl">

    <!-- Section 1: Batch Generator (Recommended) -->
    <div class="bg-gradient-to-br from-amber-50 to-orange-50/50 rounded-3xl border-2 border-amber-300 p-8 shadow-xs">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-stone-950 uppercase tracking-wider">Fast-Track</span>
            <h2 class="text-base font-bold text-stone-900">⚡ Batch Slot Generator (1-Click)</h2>
        </div>
        <p class="text-xs text-stone-600 mb-6">Quickly generate daily morning or evening Aarti slots for the next 7 to 30 days in advance.</p>

        <form action="{{ route('admin.slots.batch') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Aarti Ceremony *</label>
                <select name="aarti_id" required class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                    @foreach($aartis as $aarti)
                        <option value="{{ $aarti->id }}">{{ $aarti->title }} ({{ $aarti->ghat->city }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Starting From Date *</label>
                    <input type="date" name="start_date" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Number of Days *</label>
                    <select name="days_count" class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 font-bold">
                        <option value="7">7 Days (1 Week)</option>
                        <option value="14" selected>14 Days (2 Weeks)</option>
                        <option value="30">30 Days (1 Month)</option>
                        <option value="60">60 Days (2 Months)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Start Time *</label>
                    <input type="time" name="start_time" required value="18:30" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">End Time *</label>
                    <input type="time" name="end_time" required value="19:45" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 font-bold">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Total Seats *</label>
                    <input type="number" name="total_capacity" required value="150" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">General (₹)</label>
                    <input type="number" name="general_price" required value="0" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">VIP (₹)</label>
                    <input type="number" name="vip_price" required value="251" 
                           class="w-full bg-white border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Reporting Instruction</label>
                <input type="text" name="reporting_time" value="45 minutes prior (Gate 3)" 
                       class="w-full bg-white border border-stone-300 rounded-xl px-3.5 py-2 text-xs text-stone-900">
            </div>

            <button type="submit" class="w-full py-3 bg-stone-900 hover:bg-black text-amber-300 font-bold text-xs rounded-xl shadow-md transition-all mt-4">
                🚀 Generate Bulk Slots Now
            </button>
        </form>
    </div>

    <!-- Section 2: Single Slot Form -->
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <h2 class="text-base font-bold text-stone-900 mb-2">Create Single Slot</h2>
        <p class="text-xs text-stone-500 mb-6">Schedule an individual slot or festival special timing.</p>

        <form action="{{ route('admin.slots.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Aarti Ceremony *</label>
                <select name="aarti_id" required class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                    @foreach($aartis as $aarti)
                        <option value="{{ $aarti->id }}">{{ $aarti->title }} ({{ $aarti->ghat->city }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Date *</label>
                <input type="date" name="slot_date" required value="{{ date('Y-m-d') }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Start Time *</label>
                    <input type="time" name="start_time" required value="18:30" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">End Time *</label>
                    <input type="time" name="end_time" required value="19:45" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Total Capacity *</label>
                    <input type="number" name="total_capacity" required value="100" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">General (₹)</label>
                    <input type="number" name="general_price" required value="0" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">VIP (₹)</label>
                    <input type="number" name="vip_price" required value="251" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Status</label>
                    <select name="status" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                        <option value="active">Active</option>
                        <option value="sold_out">Sold Out</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Reporting Time Note</label>
                    <input type="text" name="reporting_time" value="45 minutes prior" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2 text-xs text-stone-900">
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all mt-4">
                Create Single Slot
            </button>
        </form>
    </div>
</div>
@endsection
