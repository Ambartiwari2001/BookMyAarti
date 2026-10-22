@extends('layouts.app')

@section('title', $ghat->name . ' - ' . $ghat->city)

@section('content')
<!-- Ghat Hero -->
<div class="relative bg-stone-900 text-white py-16 sm:py-24">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ $ghat->image_url ?? 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1600&q=80' }}" 
             alt="{{ $ghat->name }}" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/80 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-4">
            {{ $ghat->city }}, {{ $ghat->state }} • Sacred River {{ $ghat->river }}
        </div>
        <h1 class="font-cinzel text-4xl sm:text-6xl font-extrabold text-white tracking-tight">
            {{ $ghat->name }}
        </h1>
        <p class="text-sm sm:text-base text-stone-300 mt-4 max-w-3xl leading-relaxed">
            {{ $ghat->description }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: Aartis performed at this Ghat -->
        <div class="lg:col-span-2 space-y-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-orange-600">Daily Ceremonies</span>
                <h2 class="font-cinzel text-2xl font-bold text-stone-900 mt-1">Aartis Celebrated at {{ $ghat->name }}</h2>
            </div>

            @if($ghat->aartis->isEmpty())
                <div class="p-8 bg-white rounded-3xl border border-stone-200 text-center text-xs text-stone-500">
                    No active ceremonies currently scheduled at this ghat.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($ghat->aartis as $aarti)
                        <div class="bg-white rounded-3xl border border-stone-200 overflow-hidden shadow-xs hover:shadow-lg transition-all flex flex-col justify-between p-6">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $aarti->aarti_type === 'morning' ? 'bg-amber-100 text-amber-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($aarti->aarti_type) }}
                                </span>
                                <h3 class="font-cinzel text-lg font-bold text-stone-900 mt-2">{{ $aarti->title }}</h3>
                                <p class="text-xs text-stone-600 mt-2 line-clamp-2">{{ $aarti->description }}</p>
                                <div class="mt-3 text-xs text-stone-500 font-medium">⏱ {{ $aarti->timing_summary }}</div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-stone-900">
                                    {{ $aarti->base_price == 0 ? 'Free & VIP' : '₹' . number_format($aarti->base_price, 0) }}
                                </span>
                                <a href="{{ route('aartis.show', $aarti->slug) }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 rounded-xl hover:bg-orange-700 transition-colors">
                                    Book Pass &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Location & Address Details -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 space-y-6">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-stone-900 mb-2">Gate Instructions & Reporting</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        {{ $ghat->reporting_instructions ?? 'Please report at the designated temple entry gate 40-45 minutes prior to twilight Aarti.' }}
                    </p>
                </div>
                <div class="border-t border-stone-100 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-stone-900 mb-2">Devotee Guidelines</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        {{ $ghat->guidelines ?? 'Footwear must be deposited at the free shoe rack. Photography allowed from designated viewing tiers.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Ghat Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-stone-200 shadow-lg p-6 space-y-6 sticky top-28">
                <h3 class="font-cinzel text-lg font-bold text-stone-900">Ghat Information</h3>
                
                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-stone-400 font-semibold block">Full Address</span>
                        <p class="text-stone-800 font-medium mt-1">{{ $ghat->address }}</p>
                    </div>

                    <div class="border-t border-stone-100 pt-4">
                        <span class="text-stone-400 font-semibold block">Seva Helpline</span>
                        <p class="text-stone-900 font-bold mt-1 text-sm">{{ $ghat->contact_helpline ?? '+91 542 2277123' }}</p>
                    </div>

                    <div class="border-t border-stone-100 pt-4">
                        <span class="text-stone-400 font-semibold block">Nearest Landmark</span>
                        <p class="text-stone-800 font-medium mt-1">{{ $ghat->city }} Sacred Riverbank Corridor</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-100">
                    <a href="{{ route('aartis.index', ['city' => $ghat->city]) }}" class="w-full block py-3 text-center text-xs font-bold text-white bg-stone-900 hover:bg-orange-600 rounded-xl transition-colors">
                        Browse All {{ $ghat->city }} Passes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
