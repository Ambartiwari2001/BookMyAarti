@extends('layouts.admin')

@section('page_title', 'Sacred Offerings & Prasad Management')
@section('page_subtitle', 'Manage optional offerings, deepams and boat seating add-ons')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-base font-bold text-stone-900">Offerings Catalog ({{ $addOns->total() }})</h2>
        <a href="{{ route('admin.add-ons.create') }}" class="px-4 py-2 text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-colors shadow-xs">
            + New Offering
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Offering Item</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @foreach($addOns as $item)
                    <tr class="hover:bg-stone-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-stone-900">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-500 text-sm">🪔</span>
                                <span>{{ $item->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-orange-600">
                            ₹{{ number_format($item->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-stone-600 max-w-sm truncate">
                            {{ $item->description }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $item->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.add-ons.edit', $item->id) }}" class="text-orange-600 font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.add-ons.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this offering?')">
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
            {{ $addOns->links() }}
        </div>
    </div>
</div>
@endsection
