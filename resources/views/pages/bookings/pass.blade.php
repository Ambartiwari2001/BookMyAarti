@extends('layouts.app')

@section('title', 'Sacred E-Pass: ' . $booking->booking_number)

@section('content')
<div class="py-12 bg-stone-100 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">

        <!-- Top Action Bar (hidden when printing) -->
        <div class="no-print flex items-center justify-between mb-6">
            <a href="{{ route('my-bookings') }}" class="text-xs font-semibold text-stone-600 hover:text-stone-900 flex items-center gap-1.5">
                &larr; Back to My Bookings
            </a>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="px-4 py-2 text-xs font-bold text-stone-900 bg-white border border-stone-300 rounded-xl shadow-xs hover:bg-stone-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print / Save PDF</span>
                </button>
            </div>
        </div>

        <!-- The Sacred E-Pass Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-stone-200 overflow-hidden text-stone-900">
            <!-- Pass Top Banner -->
            <div class="bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 text-white p-6 sm:p-8 relative">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-stone-900/40 backdrop-blur-md p-2 flex items-center justify-center text-amber-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C12 2 8 8 8 13C8 15.2091 9.79086 17 12 17C14.2091 17 16 15.2091 16 13C16 8 12 2 12 2Z" fill="#FDE68A" />
                                <path d="M4 17C4 19.2091 7.58172 21 12 21C16.4183 21 20 19.2091 20 17H4Z" fill="#D97706" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-widest text-amber-200">Official Temple Trust Entry Pass</span>
                            <h1 class="font-cinzel text-xl sm:text-2xl font-black tracking-tight text-white">BookMyAarti Darshan Pass</h1>
                        </div>
                    </div>

                    <div class="text-left sm:text-right">
                        <span class="text-[10px] uppercase tracking-wider text-amber-200 block">Pass Reference</span>
                        <span class="font-mono text-base sm:text-lg font-black tracking-wider text-white bg-black/20 px-3 py-1 rounded-lg inline-block mt-0.5">
                            {{ $booking->booking_number }}
                        </span>
                    </div>
                </div>

                <!-- Status Pill -->
                <div class="mt-4 flex items-center gap-2">
                    @if($booking->booking_status === 'confirmed')
                        <span class="px-3 py-1 rounded-full text-xs font-black tracking-wide uppercase bg-emerald-500 text-white flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            Confirmed & Valid for Entry
                        </span>
                    @elseif($booking->booking_status === 'checked_in')
                        <span class="px-3 py-1 rounded-full text-xs font-black tracking-wide uppercase bg-stone-900 text-amber-400">
                            ✓ Checked-In at {{ $booking->checked_in_at->format('h:i A') }}
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-black tracking-wide uppercase bg-rose-700 text-white">
                            Cancelled Pass
                        </span>
                    @endif

                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-white/20 text-white">
                        {{ strtoupper($booking->seating_type) }} SEATING
                    </span>
                </div>
            </div>

            <!-- Ceremony Info & QR Barcode -->
            <div class="p-6 sm:p-8 border-b border-stone-200 grid grid-cols-1 md:grid-cols-3 gap-6 items-center bg-stone-50/50">
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500">Sacred Ceremony</span>
                        <h2 class="font-cinzel text-xl sm:text-2xl font-bold text-stone-900">
                            {{ $booking->slot->aarti->title }}
                        </h2>
                        <p class="text-xs font-semibold text-orange-600 mt-0.5">
                            📍 {{ $booking->slot->aarti->ghat->name }}, {{ $booking->slot->aarti->ghat->city }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-xs pt-2">
                        <div class="bg-white p-3 rounded-xl border border-stone-200">
                            <span class="text-stone-400 font-semibold block">Date:</span>
                            <span class="font-bold text-stone-900 text-sm">{{ $booking->slot->slot_date->format('D, d M Y') }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-stone-200">
                            <span class="text-stone-400 font-semibold block">Aarti Timing:</span>
                            <span class="font-bold text-stone-900 text-sm">{{ $booking->slot->formatted_time }}</span>
                        </div>
                    </div>

                    <div class="bg-amber-500/10 border border-amber-500/30 p-3 rounded-xl text-xs text-amber-900 flex items-center gap-2">
                        <span class="text-amber-600 font-bold text-sm">⚠️</span>
                        <span><strong>Reporting Time:</strong> {{ $booking->slot->reporting_time ?? '45 minutes prior' }}. Gates close 15 minutes before chanting begins.</span>
                    </div>
                </div>

                <!-- QR Code Box -->
                <div class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border-2 border-dashed border-stone-300 text-center">
                    <!-- SVG Authentic QR Simulation -->
                    <div class="w-32 h-32 bg-stone-900 p-2 rounded-xl flex items-center justify-center shadow-inner">
                        <svg class="w-28 h-28 text-white" viewBox="0 0 100 100" fill="currentColor">
                            <!-- Simulated high-density QR matrix -->
                            <rect x="5" y="5" width="28" height="28" fill="white" />
                            <rect x="9" y="9" width="20" height="20" fill="black" />
                            <rect x="13" y="13" width="12" height="12" fill="white" />

                            <rect x="67" y="5" width="28" height="28" fill="white" />
                            <rect x="71" y="9" width="20" height="20" fill="black" />
                            <rect x="75" y="13" width="12" height="12" fill="white" />

                            <rect x="5" y="67" width="28" height="28" fill="white" />
                            <rect x="9" y="71" width="20" height="20" fill="black" />
                            <rect x="13" y="75" width="12" height="12" fill="white" />

                            <!-- Data modules pattern -->
                            <rect x="40" y="10" width="8" height="8" fill="white" />
                            <rect x="52" y="10" width="8" height="8" fill="white" />
                            <rect x="40" y="24" width="8" height="8" fill="white" />
                            <rect x="40" y="40" width="20" height="20" fill="white" />
                            <rect x="10" y="44" width="8" height="8" fill="white" />
                            <rect x="24" y="44" width="8" height="8" fill="white" />
                            <rect x="70" y="44" width="16" height="8" fill="white" />
                            <rect x="44" y="70" width="14" height="14" fill="white" />
                            <rect x="70" y="70" width="18" height="18" fill="white" />
                        </svg>
                    </div>
                    <span class="font-mono text-[10px] text-stone-500 mt-2 font-bold">{{ $booking->qr_token }}</span>
                    <span class="text-[10px] text-stone-400">Scan at Entry Gate</span>
                </div>
            </div>

            <!-- Devotee & Sankalp List -->
            <div class="p-6 sm:p-8 border-b border-stone-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-cinzel text-base font-bold text-stone-900">
                        Registered Devotees ({{ $booking->devotee_count }})
                    </h3>
                    <span class="text-xs text-stone-500">Contact: {{ $booking->contact_name }} ({{ $booking->contact_phone }})</span>
                </div>

                <div class="divide-y divide-stone-100 border border-stone-200 rounded-2xl overflow-hidden text-xs">
                    @foreach($booking->devotees as $index => $devotee)
                        <div class="p-3.5 bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full bg-stone-100 font-bold text-stone-700 flex items-center justify-center text-[10px]">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <span class="font-bold text-stone-900">{{ $devotee->name }}</span>
                                    @if($devotee->age)
                                        <span class="text-stone-500">({{ $devotee->age }} yrs, {{ ucfirst($devotee->gender) }})</span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-stone-600 sm:text-right">
                                @if($devotee->gotra)
                                    <span class="inline-block px-2 py-0.5 rounded-md bg-stone-100 font-semibold text-stone-700 mr-2">Gotra: {{ $devotee->gotra }}</span>
                                @endif
                                @if($devotee->sankalp_purpose)
                                    <span class="italic text-stone-500">"{{ $devotee->sankalp_purpose }}"</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Offerings & Payment Summary -->
            <div class="p-6 sm:p-8 bg-stone-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-xs">
                <div>
                    @if($booking->bookingAddOns->isNotEmpty())
                        <span class="font-bold text-stone-800 block mb-1">Sanctified Offerings to Collect:</span>
                        <ul class="space-y-1 text-stone-600">
                            @foreach($booking->bookingAddOns as $item)
                                <li>🪔 {{ $item->addOn->name }} &times; {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-stone-500">Standard Gate Admission Pass</span>
                    @endif
                </div>

                <div class="text-right sm:border-l sm:border-stone-200 sm:pl-6 w-full sm:w-auto">
                    <span class="text-stone-400 block text-[11px]">Total Paid / Amount</span>
                    <span class="font-cinzel text-xl font-bold text-stone-900">
                        {{ $booking->total_amount > 0 ? '₹' . number_format($booking->total_amount, 2) : 'Free Complimentary Seva' }}
                    </span>
                    <span class="block text-[10px] text-stone-500 capitalize">{{ $booking->payment_method }}</span>
                </div>
            </div>

            <!-- Pass Bottom Guidelines -->
            <div class="p-4 bg-stone-900 text-stone-400 text-[11px] text-center leading-relaxed">
                Please display this pass on your smartphone screen at Gate 3. Plastic items are prohibited. Har Har Gange!
            </div>
        </div>

        <!-- Cancellation Option (Devotee Self-Service) -->
        @if($booking->booking_status === 'confirmed')
            <div class="no-print mt-8 text-center">
                <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you wish to cancel this Aarti pass? The reserved slot capacity will be released for other devotees.')">
                    @csrf
                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 underline font-medium">
                        Cancel This Booking
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
