@extends('layouts.app')

@section('title', 'Explore Sacred Ghats - Varanasi, Haridwar & Rishikesh')

@section('content')
<div class="bg-stone-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Sacred Riverbanks</span>
        <h1 class="font-cinzel text-3xl sm:text-5xl font-extrabold text-white mt-2">
            The Holy Ghats of Ganga
        </h1>
        <p class="text-sm text-stone-300 mt-2 max-w-2xl">
            Explore the spiritual riverfronts where the sacred current of Maa Ganga has met devotion for millennia.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($ghats as $ghat)
            <div class="bg-white rounded-3xl overflow-hidden border border-stone-200 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">
                <div class="relative h-64 overflow-hidden bg-stone-900">
                    <img src="{{ $ghat->image_url ?? 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80' }}" 
                         alt="{{ $ghat->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-950/80 via-transparent to-transparent"></div>

                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500 text-stone-950">
                            {{ $ghat->city }}, {{ $ghat->state }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="text-xs text-amber-300 font-semibold">River {{ $ghat->river }}</span>
                        <h2 class="font-cinzel text-2xl font-bold">{{ $ghat->name }}</h2>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                            {{ $ghat->description }}
                        </p>
                        <div class="mt-4 pt-4 border-t border-stone-100 text-xs text-stone-500 flex items-center gap-2">
                            <span>📍</span>
                            <span>{{ $ghat->address }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-stone-700">
                            {{ $ghat->aartis->count() }} Registered Ceremonies
                        </span>
                        <a href="{{ route('ghats.show', $ghat->slug) }}" class="px-5 py-2.5 text-xs font-bold text-white bg-stone-900 group-hover:bg-orange-600 rounded-xl transition-all">
                            View Ceremonies &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
