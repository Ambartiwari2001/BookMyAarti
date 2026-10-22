@extends('layouts.admin')

@section('page_title', 'Edit Ghat: ' . $ghat->name)
@section('page_subtitle', 'Update address, reporting guidelines and phone helpline')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.ghats.update', $ghat->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Name *</label>
                    <input type="text" name="name" required value="{{ old('name', $ghat->name) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">City *</label>
                    <input type="text" name="city" required value="{{ old('city', $ghat->city) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">State *</label>
                    <input type="text" name="state" required value="{{ old('state', $ghat->state) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Sacred River *</label>
                    <input type="text" name="river" required value="{{ old('river', $ghat->river) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Full Address *</label>
                <input type="text" name="address" required value="{{ old('address', $ghat->address) }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Cover Image URL</label>
                    <input type="text" name="image_url" value="{{ old('image_url', $ghat->image_url) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Helpline Phone</label>
                    <input type="text" name="contact_helpline" value="{{ old('contact_helpline', $ghat->contact_helpline) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">History & Description</label>
                <textarea name="description" rows="3" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('description', $ghat->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Reporting Instructions (Printed on Pass)</label>
                <textarea name="reporting_instructions" rows="2" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('reporting_instructions', $ghat->reporting_instructions) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Guidelines & Restrictions</label>
                <textarea name="guidelines" rows="2" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('guidelines', $ghat->guidelines) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" {{ $ghat->is_active ? 'checked' : '' }} class="rounded-sm text-orange-600">
                    <span>Active Ghat Sanctuary</span>
                </label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Update Ghat
                </button>
                <a href="{{ route('admin.ghats.index') }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
