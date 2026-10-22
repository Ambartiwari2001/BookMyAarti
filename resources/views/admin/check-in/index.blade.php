@extends('layouts.admin')

@section('page_title', 'Ghat Gate Pass Scanner & Check-In')
@section('page_subtitle', 'Fast QR / reference verification for tier entry coordinators')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Scanner / Search Input Box -->
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs text-center">
        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-stone-950 flex items-center justify-center mx-auto mb-4 shadow-md shadow-amber-500/20">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
        </div>
        <h2 class="text-lg font-bold text-stone-900">Scan or Enter Devotee Pass Code</h2>
        <p class="text-xs text-stone-500 mt-1 max-w-sm mx-auto">
            Scan barcode with gate scanner or enter Booking Number (e.g. BMA-2026-A101) or QR token hash.
        </p>

        <form action="{{ route('admin.check-in.index') }}" method="GET" class="mt-6 flex gap-2">
            <input type="text" name="code" value="{{ $query }}" autofocus required 
                   placeholder="Enter Booking Number or paste QR Token..." 
                   class="flex-1 bg-stone-50 border-2 border-stone-300 focus:border-amber-500 rounded-2xl px-4 py-3 text-sm font-mono font-bold text-stone-900 focus:outline-hidden text-center">
            <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-stone-950 font-bold text-xs rounded-2xl shadow-xs transition-colors">
                Verify Pass
            </button>
        </form>

        @if($error)
            <div class="mt-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ $error }}
            </div>
        @endif
    </div>

    <!-- Verification Result Card (When a code is searched) -->
    @if($booking)
        <div class="bg-white rounded-3xl border-2 {{ $booking->booking_status === 'confirmed' ? 'border-emerald-500' : ($booking->booking_status === 'checked_in' ? 'border-amber-500' : 'border-rose-500') }} p-8 shadow-lg space-y-6">
            
            <!-- Result Banner -->
            <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                <div>
                    <span class="font-mono text-base font-extrabold text-stone-900">{{ $booking->booking_number }}</span>
                    <span class="block text-xs text-stone-500">Contact: {{ $booking->contact_name }} ({{ $booking->contact_phone }})</span>
                </div>

                <div>
                    @if($booking->booking_status === 'confirmed')
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-emerald-100 text-emerald-800 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            Valid for Entry
                        </span>
                    @elseif($booking->booking_status === 'checked_in')
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-amber-100 text-amber-800">
                            Already Admitted ({{ $booking->checked_in_at->format('h:i A') }})
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase bg-rose-100 text-rose-800">
                            Cancelled Pass (Do Not Admit)
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div class="bg-stone-50 p-4 rounded-2xl">
                    <span class="text-stone-400 block font-medium">Aarti Ceremony</span>
                    <span class="font-bold text-stone-900 text-sm mt-0.5 block">{{ $booking->slot->aarti->title }}</span>
                    <span class="text-stone-600">{{ $booking->slot->aarti->ghat->name }}</span>
                </div>

                <div class="bg-stone-50 p-4 rounded-2xl">
                    <span class="text-stone-400 block font-medium">Slot & Seating</span>
                    <span class="font-bold text-stone-900 text-sm mt-0.5 block">{{ $booking->slot->formatted_time }}</span>
                    <span class="font-bold text-orange-600 uppercase">{{ $booking->seating_type }} TIER • {{ $booking->devotee_count }} Devotees</span>
                </div>
            </div>

            <!-- Devotee Names list -->
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400 block mb-2">Devotees to Admit:</span>
                <div class="bg-stone-50 rounded-2xl p-4 divide-y divide-stone-200 text-xs">
                    @foreach($booking->devotees as $devotee)
                        <div class="py-2 flex justify-between items-center first:pt-0 last:pb-0">
                            <span class="font-bold text-stone-900">👤 {{ $devotee->name }}</span>
                            <span class="text-stone-500">Gotra: {{ $devotee->gotra ?: 'N/A' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Offerings to hand over -->
            @if($booking->bookingAddOns->isNotEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs">
                    <span class="font-bold text-amber-900 block mb-1">🎁 Hand Over Offerings to Devotee:</span>
                    <ul class="space-y-1 text-amber-800">
                        @foreach($booking->bookingAddOns as $item)
                            <li>• {{ $item->addOn->name }} &times; {{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Confirm Action -->
            @if($booking->booking_status === 'confirmed')
                <form action="{{ route('admin.check-in.confirm', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2">
                        <span>✓ CONFIRM DEVOTEE GATE ENTRY</span>
                    </button>
                </form>
            @elseif($booking->booking_status === 'checked_in')
                <div class="text-center p-3 bg-stone-100 rounded-2xl text-stone-600 text-xs font-bold">
                    Devotee group was already verified at {{ $booking->checked_in_at->format('h:i:s A, d M Y') }}.
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
