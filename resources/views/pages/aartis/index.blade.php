@extends('layouts.app')

@section('title', 'Explore & Book Ganga Aarti Passes')

@section('content')
<div class="bg-stone-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Ceremony Catalog</span>
        <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white mt-2">
            Sacred Aarti Ceremonies
        </h1>
        <p class="text-sm text-stone-300 mt-2 max-w-2xl">
            Choose from sacred morning and evening rituals along the banks of Holy River Ganga.
        </p>

        <!-- Filter Bar -->
        <div class="mt-8 bg-stone-800/80 backdrop-blur-md p-4 rounded-2xl border border-stone-700/80">
            <form action="{{ route('aartis.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-400 mb-1">City Filter</label>
                    <select name="city" onchange="this.form.submit()" class="w-full bg-stone-900 border border-stone-700 rounded-xl px-3 py-2 text-xs font-semibold text-white focus:outline-hidden focus:ring-1 focus:ring-amber-500">
                        <option value="">All Sacred Cities</option>
                        @foreach($cities as $c)
                            <option value="{{ $c }}" {{ $city === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-400 mb-1">Ritual Type</label>
                    <select name="type" onchange="this.form.submit()" class="w-full bg-stone-900 border border-stone-700 rounded-xl px-3 py-2 text-xs font-semibold text-white focus:outline-hidden focus:ring-1 focus:ring-amber-500">
                        <option value="">All Timings</option>
                        <option value="evening" {{ $type === 'evening' ? 'selected' : '' }}>Evening Sandhya Aarti</option>
                        <option value="morning" {{ $type === 'morning' ? 'selected' : '' }}>Morning Subah-e-Banaras</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('aartis.index') }}" class="w-full py-2 px-3 text-center text-xs font-semibold text-stone-400 hover:text-white bg-stone-700/60 rounded-xl transition-colors">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    @if($aartis->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-stone-200">
            <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900">No ceremonies match your selected filter</h3>
            <p class="text-xs text-stone-500 mt-1">Try resetting the city or ceremony timing filter.</p>
            <a href="{{ route('aartis.index') }}" class="mt-4 inline-block px-5 py-2 text-xs font-bold text-white bg-orange-600 rounded-xl">Reset Filters</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($aartis as $aarti)
                <div class="bg-white rounded-3xl overflow-hidden border border-stone-200 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <div class="relative h-56 bg-stone-900 overflow-hidden">
                        <img src="{{ $aarti->banner_image ?? 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $aarti->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent"></div>

                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 text-stone-900 backdrop-blur-md shadow-xs">
                                {{ $aarti->ghat->city }}
                            </span>
                            @if($aarti->aarti_type === 'morning')
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-500 text-stone-950">
                                    Morning
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-600 text-white">
                                    Evening
                                </span>
                            @endif
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-xs text-amber-300 font-semibold block">{{ $aarti->timing_summary }}</span>
                            <span class="text-[11px] text-stone-300">Duration: {{ $aarti->duration_minutes }} Mins</span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider block mb-1">
                                {{ $aarti->ghat->name }}
                            </span>
                            <h2 class="font-cinzel text-xl font-bold text-stone-900 group-hover:text-orange-600 transition-colors">
                                {{ $aarti->title }}
                            </h2>
                            <p class="text-xs text-stone-600 mt-2.5 line-clamp-3 leading-relaxed">
                                {{ $aarti->description }}
                            </p>
                        </div>

                        <div class="mt-8 pt-5 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-stone-500 uppercase tracking-wider block">Pricing</span>
                                <span class="text-xs font-bold text-stone-900">
                                    {{ $aarti->base_price == 0 ? 'Free & VIP Pass' : '₹' . number_format($aarti->base_price, 0) . ' onwards' }}
                                </span>
                            </div>
                            <a href="{{ route('aartis.show', $aarti->slug) }}" class="px-5 py-2.5 text-xs font-bold text-white bg-stone-900 group-hover:bg-orange-600 rounded-xl transition-all shadow-md">
                                View Slots &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
