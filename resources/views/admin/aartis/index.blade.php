@extends('layouts.admin')

@section('page_title', 'Aarti Ceremonies Management')
@section('page_subtitle', 'Configure Daily Ceremonies, Timings & Pricing Tiers')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-base font-bold text-stone-900">All Ceremonies ({{ $aartis->total() }})</h2>
        <a href="{{ route('admin.aartis.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-colors shadow-xs">
            + New Aarti Listing
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Ceremony</th>
                    <th class="px-6 py-4">Holy Ghat</th>
                    <th class="px-6 py-4">Timing & Duration</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Base Pricing</th>
                    <th class="px-6 py-4">Slots Count</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($aartis as $aarti)
                    <tr class="hover:bg-stone-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-stone-900">
                            <div class="flex items-center gap-3">
                                <img src="{{ $aarti->banner_image ?? 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=100&q=80' }}" class="w-10 h-10 rounded-xl object-cover">
                                <div>
                                    <div class="font-bold text-stone-900">{{ $aarti->title }}</div>
                                    @if($aarti->is_featured)
                                        <span class="text-[10px] text-amber-600 font-bold uppercase tracking-wider">★ Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-stone-800">{{ $aarti->ghat->name }}</span>
                            <span class="block text-[11px] text-stone-400">{{ $aarti->ghat->city }}</span>
                        </td>
                        <td class="px-6 py-4 text-stone-600">
                            <div>{{ $aarti->timing_summary }}</div>
                            <div class="text-[11px] text-stone-400">{{ $aarti->duration_minutes }} Mins</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $aarti->aarti_type === 'morning' ? 'bg-amber-100 text-amber-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ $aarti->aarti_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-stone-900">
                            {{ $aarti->base_price == 0 ? 'Free Darshan' : '₹' . number_format($aarti->base_price, 0) }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-stone-700">
                            {{ $aarti->slots_count }} Scheduled
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $aarti->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $aarti->is_active ? 'Active' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.aartis.edit', $aarti->id) }}" class="text-orange-600 font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.aartis.destroy', $aarti->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this aarti listing?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 border-t border-stone-200">
            {{ $aartis->links() }}
        </div>
    </div>
</div>
@endsection
