@extends('layouts.app')

@section('title', $aarti->title . ' - ' . $aarti->ghat->name)

@section('content')
<!-- Detail Header -->
<div class="relative bg-stone-900 text-white py-16 sm:py-24">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ $aarti->banner_image ?? 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=1600&q=80' }}" 
             alt="{{ $aarti->title }}" 
             class="w-full h-full object-cover opacity-25">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/80 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <a href="{{ route('ghats.show', $aarti->ghat->slug) }}" class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 hover:bg-amber-500/30 transition-colors">
                📍 {{ $aarti->ghat->name }}, {{ $aarti->ghat->city }}
            </a>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-stone-200">
                ⏱ {{ $aarti->timing_summary }}
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-stone-200">
                ⏳ Duration: {{ $aarti->duration_minutes }} Mins
            </span>
        </div>

        <h1 class="font-cinzel text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight max-w-4xl">
            {{ $aarti->title }}
        </h1>
        <p class="text-sm sm:text-base text-stone-300 mt-4 max-w-3xl leading-relaxed">
            {{ $aarti->description }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Ritual Details, Significance & Guidelines -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Spiritual Significance -->
            @if($aarti->significance)
            <div class="bg-amber-500/5 border border-amber-500/20 rounded-3xl p-6 sm:p-8">
                <div class="flex items-center gap-3 text-orange-600 mb-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C12 2 8 8 8 13C8 15.2091 9.79086 17 12 17C14.2091 17 16 15.2091 16 13C16 8 12 2 12 2Z" /></svg>
                    <h2 class="font-cinzel text-xl font-bold text-stone-900">Spiritual Significance & Mahima</h2>
                </div>
                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed">
                    {{ $aarti->significance }}
                </p>
            </div>
            @endif

            <!-- Ritual Steps -->
            @if($aarti->ritual_steps)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs">
                <h2 class="font-cinzel text-xl font-bold text-stone-900 mb-4">
                    Ceremonial Sequence (Vidhi)
                </h2>
                <div class="text-xs sm:text-sm text-stone-700 leading-relaxed whitespace-pre-line bg-stone-50 p-5 rounded-2xl border border-stone-100 font-mono">
                    {{ $aarti->ritual_steps }}
                </div>
            </div>
            @endif

            <!-- Ghat Guidelines & Reporting Instructions -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-xs space-y-6">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-stone-900 mb-2">Gate Reporting & Verification</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        {{ $aarti->ghat->reporting_instructions ?? 'Report at the designated seva entry gate with your digital E-Pass on mobile at least 45 minutes prior.' }}
                    </p>
                </div>

                <div class="border-t border-stone-100 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-stone-900 mb-2">Devotee Guidelines & Dress Code</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        {{ $aarti->ghat->guidelines ?? 'Traditional attire (Kurta/Dhoti for men, Saree/Salwar for women) is respectful. Footwear counters are available near the entrance.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Slot Calendar & Reservation Box -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 bg-white rounded-3xl border border-stone-200 shadow-xl p-6">
                <div class="border-b border-stone-100 pb-4 mb-6">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-orange-600 block">Reserve Aarti Slot</span>
                    <h3 class="font-cinzel text-xl font-bold text-stone-900 mt-1">Available Dates & Timings</h3>
                    <p class="text-xs text-stone-500 mt-1">Select your preferred date to view real-time seat availability.</p>
                </div>

                @if($slots->isEmpty())
                    <div class="text-center py-8 text-stone-500 text-xs">
                        No upcoming active slots available for this ceremony at the moment. Please check back soon or contact helpline.
                    </div>
                @else
                    <div class="space-y-6 max-h-[500px] overflow-y-auto pr-2">
                        @foreach($slots as $dateString => $daySlots)
                            @php
                                $dateObj = Carbon\Carbon::parse($dateString);
                            @endphp
                            <div class="space-y-2.5">
                                <div class="flex items-center justify-between text-xs font-bold text-stone-700 bg-stone-100 px-3 py-1.5 rounded-xl">
                                    <span>{{ $dateObj->isToday() ? 'Today (' . $dateObj->format('d M') . ')' : ($dateObj->isTomorrow() ? 'Tomorrow (' . $dateObj->format('d M') . ')' : $dateObj->format('D, d M Y')) }}</span>
                                    <span class="text-[10px] text-stone-500 font-normal">{{ $daySlots->count() }} slot(s)</span>
                                </div>

                                @foreach($daySlots as $slot)
                                    <div class="p-4 rounded-2xl border {{ $slot->is_sold_out ? 'bg-stone-50 border-stone-200 opacity-60' : 'bg-white border-stone-200 hover:border-orange-500 shadow-xs hover:shadow-md' }} transition-all flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-bold text-stone-900">
                                                {{ $slot->formatted_time }}
                                            </div>
                                            <div class="text-[11px] text-stone-500 mt-0.5">
                                                Reporting: {{ $slot->reporting_time ?? '45 mins prior' }}
                                            </div>
                                            <div class="mt-2 flex items-center gap-2">
                                                @if($slot->is_sold_out)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Full / Sold Out</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                        {{ $slot->available_seats }} Seats Left
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            @if($slot->is_sold_out)
                                                <button disabled class="px-3.5 py-2 text-xs font-bold text-stone-400 bg-stone-200 rounded-xl cursor-not-allowed">
                                                    Full
                                                </button>
                                            @else
                                                <a href="{{ route('booking.create', $slot->id) }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl shadow-xs transition-colors block text-center">
                                                    Book Pass
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 pt-4 border-t border-stone-100 text-center">
                    <p class="text-[11px] text-stone-500">Need help booking for large groups? Call <span class="font-bold text-stone-700">+91 542 2277123</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
