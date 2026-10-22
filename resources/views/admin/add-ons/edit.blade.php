@extends('layouts.admin')

@section('page_title', 'Edit Offering: ' . $addOn->name)
@section('page_subtitle', 'Update pricing or description of this spiritual offering')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.add-ons.update', $addOn->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Offering Name *</label>
                <input type="text" name="name" required value="{{ old('name', $addOn->name) }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Offering Price (₹) *</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price', $addOn->price) }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('description', $addOn->description) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" {{ $addOn->is_active ? 'checked' : '' }} class="rounded-sm text-orange-600">
                    <span>Available in Devotee Checkout</span>
                </label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Update Offering
                </button>
                <a href="{{ route('admin.add-ons.index') }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
