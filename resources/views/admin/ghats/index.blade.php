@extends('layouts.admin')

@section('page_title', 'Holy Ghats & Sanctuaries')
@section('page_subtitle', 'Manage sacred riverbank locations, capacities and guidelines')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-base font-bold text-stone-900">All Sacred Ghats ({{ $ghats->total() }})</h2>
        <a href="{{ route('admin.ghats.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-colors shadow-xs">
            + New Ghat Location
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Ghat Name</th>
                    <th class="px-6 py-4">City & State</th>
                    <th class="px-6 py-4">River</th>
                    <th class="px-6 py-4">Ceremonies Count</th>
                    <th class="px-6 py-4">Seva Helpline</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($ghats as $ghat)
                    <tr class="hover:bg-stone-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $ghat->image_url ?? 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=100&q=80' }}" class="w-10 h-10 rounded-xl object-cover">
                                <div>
                                    <div class="font-bold text-stone-900">{{ $ghat->name }}</div>
                                    <div class="text-[11px] text-stone-400 truncate max-w-xs">{{ $ghat->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-stone-800">
                            {{ $ghat->city }}, {{ $ghat->state }}
                        </td>
                        <td class="px-6 py-4 font-medium text-stone-600">
                            {{ $ghat->river }}
                        </td>
                        <td class="px-6 py-4 font-bold text-stone-900">
                            {{ $ghat->aartis_count }}
                        </td>
                        <td class="px-6 py-4 text-stone-600">
                            {{ $ghat->contact_helpline ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $ghat->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $ghat->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.ghats.edit', $ghat->id) }}" class="text-orange-600 font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.ghats.destroy', $ghat->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this ghat?')">
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
            {{ $ghats->links() }}
        </div>
    </div>
</div>
@endsection
