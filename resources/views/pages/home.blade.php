@extends('layouts.app')

@section('title', 'Book Sacred Ganga Aarti & Darshan Passes Online')

@section('content')
<!-- Hero Section -->
<section class="relative bg-stone-900 text-white overflow-hidden py-24 sm:py-32">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=2000&q=80" 
             alt="Varanasi Ganga Aarti" 
             class="w-full h-full object-cover object-center opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-900/80 to-stone-900/60"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Sacred Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-semibold mb-8 backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
            <span>Official Digital Portal for Sacred Riverbank Ceremonies</span>
        </div>

        <h1 class="font-cinzel text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight max-w-5xl mx-auto">
            Book Sacred <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-400 to-amber-200">Ganga Aarti</span> & Ghat Darshan Passes
        </h1>

        <p class="max-w-2xl mx-auto text-base sm:text-lg text-stone-300 leading-relaxed mb-10">
            Guarantee your family's front-tier seating, personal Sankalp rituals, and holy Prasad offerings at the immortal ghats of Varanasi, Haridwar, and Rishikesh.
        </p>

        <!-- Quick Slot Finder Bar -->
        <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-xl p-4 sm:p-5 rounded-3xl shadow-2xl shadow-black/40 border border-stone-200 text-stone-900">
            <form action="{{ route('aartis.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <!-- City Selection -->
                <div class="text-left">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-500 mb-1 ml-1">Holy Destination</label>
                    <select name="city" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2.5 text-sm font-semibold text-stone-800 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        <option value="">All Sacred Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ceremony Type -->
                <div class="text-left">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-500 mb-1 ml-1">Ceremony Time</label>
                    <select name="type" class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2.5 text-sm font-semibold text-stone-800 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                        <option value="">Any Timing</option>
                        <option value="evening">Evening Sandhya Aarti (06:30 PM)</option>
                        <option value="morning">Morning Subah-e-Banaras (05:30 AM)</option>
                    </select>
                </div>

                <!-- Date -->
                <div class="text-left">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-500 mb-1 ml-1">Darshan Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3 py-2.5 text-sm font-semibold text-stone-800 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Find Passes
                    </button>
                </div>
            </form>
        </div>

        <!-- Metric Badges -->
        <div class="mt-14 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto pt-8 border-t border-stone-800/80 text-stone-400">
            <div>
                <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">100% Free</div>
                <div class="text-xs text-stone-400 mt-1">General Darshan Passes</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">7 Vedic</div>
                <div class="text-xs text-stone-400 mt-1">Priests Synchronized Aarti</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">VIP Platforms</div>
                <div class="text-xs text-stone-400 mt-1">Dais & Boat Front Seating</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">Instant QR</div>
                <div class="text-xs text-stone-400 mt-1">Digital Gate Entry Pass</div>
            </div>
        </div>
    </div>
</section>

<!-- Today's Live Aarti Lineup -->
@if($upcomingTodaySlots->isNotEmpty())
<section class="bg-amber-500/10 border-y border-amber-500/20 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="p-2.5 rounded-xl bg-orange-600 text-white">
                    <svg class="w-5 h-5 animate-spin" style="animation-duration: 8s;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-stone-900 uppercase tracking-wider">Today's Sacred Aarti Slots ({{ date('d M Y') }})</h3>
                    <p class="text-xs text-stone-600">Limited seats remaining for tonight's rituals. Reserve your verified pass before cutoff.</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @foreach($upcomingTodaySlots as $slot)
                    <a href="{{ route('booking.create', $slot->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white border border-amber-300 shadow-xs hover:border-orange-500 transition-all text-xs">
                        <span class="font-bold text-stone-900">{{ $slot->aarti->ghat->city }}:</span>
                        <span class="text-stone-600">{{ Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ $slot->available_seats > 20 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $slot->available_seats }} seats
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Featured Aarti Ceremonies -->
<section class="py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-orange-600">Revered Ceremonies</span>
                <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-stone-900 mt-2">
                    Witness the Divine Flame
                </h2>
                <p class="text-sm text-stone-600 mt-2 max-w-xl">
                    Choose from world-renowned daily ceremonies held across sacred North Indian ghats.
                </p>
            </div>
            <a href="{{ route('aartis.index') }}" class="mt-4 md:mt-0 text-sm font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1">
                Browse All Aartis &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredAartis as $aarti)
                <div class="bg-white rounded-3xl overflow-hidden border border-stone-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <!-- Banner Image -->
                    <div class="relative h-48 overflow-hidden bg-stone-900">
                        <img src="{{ $aarti->banner_image ?? 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $aarti->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent"></div>
                        
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-white/90 text-stone-900 backdrop-blur-md shadow-xs">
                                {{ $aarti->ghat->city }}
                            </span>
                        </div>
                        
                        <div class="absolute bottom-3 left-3 right-3 text-white">
                            <span class="text-[11px] text-amber-300 font-medium">{{ $aarti->timing_summary }}</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-[11px] uppercase tracking-wider font-semibold text-stone-500 mb-1">
                                {{ $aarti->ghat->name }}
                            </div>
                            <h3 class="font-cinzel text-lg font-bold text-stone-900 group-hover:text-orange-600 transition-colors">
                                {{ $aarti->title }}
                            </h3>
                            <p class="text-xs text-stone-600 line-clamp-2 mt-2 leading-relaxed">
                                {{ $aarti->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-stone-500 uppercase tracking-wider block">Pass Type</span>
                                <span class="text-xs font-bold text-stone-900">
                                    {{ $aarti->base_price == 0 ? 'Free & VIP Tiers' : '₹' . number_format($aarti->base_price, 0) . ' onwards' }}
                                </span>
                            </div>
                            <a href="{{ route('aartis.show', $aarti->slug) }}" class="px-4 py-2 text-xs font-bold text-white bg-stone-900 group-hover:bg-orange-600 rounded-xl transition-colors">
                                Reserve Pass
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sacred Ghats Explorer -->
<section class="py-20 bg-stone-100/70 border-t border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-orange-600">Holy Confluences</span>
            <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-stone-900 mt-2">
                Sacred Riverbank Sanctuaries
            </h2>
            <p class="text-sm text-stone-600 mt-2">
                Discover the spiritual heritage, reporting gates, and ceremonial guidelines for each ghat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($ghats as $ghat)
                <a href="{{ route('ghats.show', $ghat->slug) }}" class="group relative rounded-3xl overflow-hidden h-80 shadow-md hover:shadow-2xl transition-all duration-300 block">
                    <img src="{{ $ghat->image_url ?? 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=800&q=80' }}" 
                         alt="{{ $ghat->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-950/40 to-transparent"></div>

                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-stone-950">
                            {{ $ghat->city }}
                        </span>
                    </div>

                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <h3 class="font-cinzel text-xl font-bold group-hover:text-amber-400 transition-colors">
                            {{ $ghat->name }}
                        </h3>
                        <p class="text-xs text-stone-300 line-clamp-2 mt-1">
                            {{ $ghat->description }}
                        </p>
                        <div class="mt-3 flex items-center justify-between text-xs text-amber-300 font-semibold">
                            <span>{{ $ghat->aartis_count }} Daily Ceremonies</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- How Devotee Booking Works -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-orange-600">Simple 3-Step Process</span>
            <h2 class="font-cinzel text-3xl sm:text-4xl font-bold text-stone-900 mt-2">
                How Devotee Booking Works
            </h2>
            <p class="text-sm text-stone-600 mt-2">
                Effortless reservation designed for visiting pilgrims and local devotees alike.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-stone-50 border border-stone-200/80 rounded-3xl p-8 relative hover:border-orange-500 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-orange-600 text-white font-cinzel text-2xl font-bold flex items-center justify-center mb-6 shadow-md shadow-orange-600/30">
                    1
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Select Ceremony & Slot</h3>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Choose your preferred holy ghat, Aarti timing (Morning or Evening), and select your desired darshan date from the real-time calendar.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-stone-50 border border-stone-200/80 rounded-3xl p-8 relative hover:border-orange-500 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-stone-950 font-cinzel text-2xl font-bold flex items-center justify-center mb-6 shadow-md shadow-amber-500/30">
                    2
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Devotee Sankalp & Add-ons</h3>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Enter the names and Gotra of your family members for priest blessings. Optionally add special Prasad hampers, floral deepams, or boat seats.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-stone-50 border border-stone-200/80 rounded-3xl p-8 relative hover:border-orange-500 transition-colors">
                <div class="w-14 h-14 rounded-2xl bg-stone-900 text-amber-400 font-cinzel text-2xl font-bold flex items-center justify-center mb-6 shadow-md shadow-stone-900/30">
                    3
                </div>
                <h3 class="text-lg font-bold text-stone-900 mb-2">Get Digital QR Gate Pass</h3>
                <p class="text-xs text-stone-600 leading-relaxed">
                    Receive your confirmed E-Pass instantly on mobile. Flash your QR code at the ghat volunteer checkpoint for seamless tier entry.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white mb-4">
            Experience the Divine Power of Mother Ganga
        </h2>
        <p class="max-w-2xl mx-auto text-amber-100 text-sm sm:text-base mb-8">
            Slots fill up quickly during weekends and auspicious festival days. Secure your darshan today.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('aartis.index') }}" class="px-8 py-3.5 bg-stone-900 hover:bg-black text-amber-400 font-bold text-sm rounded-2xl shadow-xl transition-all">
                Reserve Aarti Slot Now
            </a>
            <a href="{{ route('my-bookings') }}" class="px-8 py-3.5 bg-white/20 hover:bg-white/30 text-white font-bold text-sm rounded-2xl backdrop-blur-md transition-all">
                Retrieve Existing Pass
            </a>
        </div>
    </div>
</section>
@endsection
