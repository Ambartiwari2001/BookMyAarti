@extends('layouts.admin')

@section('page_title', 'Add New Sacred Offering')
@section('page_subtitle', 'Create prasad or ceremonial offering for booking selection')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.add-ons.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Offering Name *</label>
                <input type="text" name="name" required placeholder="e.g. Special Archana Prasad Box" value="{{ old('name') }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Offering Price (₹) *</label>
                <input type="number" step="0.01" name="price" required placeholder="e.g. 151" value="{{ old('price') }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Description</label>
                <textarea name="description" rows="3" placeholder="What is included in this offering..." 
                          class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('description') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded-sm text-orange-600">
                    <span>Available in Devotee Checkout</span>
                </label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Create Offering
                </button>
                <a href="{{ route('admin.add-ons.index') }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
