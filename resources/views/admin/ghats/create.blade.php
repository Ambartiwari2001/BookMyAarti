@extends('layouts.admin')

@section('page_title', 'Add New Sacred Ghat')
@section('page_subtitle', 'Register new riverbank location for ceremonies')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.ghats.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Dashashwamedh Ghat" value="{{ old('name') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">City *</label>
                    <input type="text" name="city" required placeholder="e.g. Varanasi" value="{{ old('city') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">State *</label>
                    <input type="text" name="state" required placeholder="e.g. Uttar Pradesh" value="{{ old('state', 'Uttar Pradesh') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Sacred River *</label>
                    <input type="text" name="river" required value="{{ old('river', 'Ganga') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Full Address *</label>
                <input type="text" name="address" required placeholder="Full street address and pin code" value="{{ old('address') }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Cover Image URL</label>
                    <input type="text" name="image_url" placeholder="https://..." value="{{ old('image_url') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Helpline Phone</label>
                    <input type="text" name="contact_helpline" placeholder="+91 ..." value="{{ old('contact_helpline') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">History & Description</label>
                <textarea name="description" rows="3" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Reporting Instructions (Printed on Pass)</label>
                <textarea name="reporting_instructions" rows="2" placeholder="e.g. Report at Gate 3 with valid ID 45 minutes prior." class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('reporting_instructions') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Ghat Guidelines & Restrictions</label>
                <textarea name="guidelines" rows="2" placeholder="e.g. Modest attire, no footwear beyond red line." class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('guidelines') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded-sm text-orange-600">
                    <span>Active Ghat Sanctuary</span>
                </label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Create Ghat Location
                </button>
                <a href="{{ route('admin.ghats.index') }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
