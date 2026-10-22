@extends('layouts.admin')

@section('page_title', 'Create Aarti Ceremony')
@section('page_subtitle', 'Add new sacred ritual to devotee booking catalog')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl border border-stone-200 p-8 shadow-xs">
        <form action="{{ route('admin.aartis.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Holy Ghat Location *</label>
                    <select name="ghat_id" required class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                        @foreach($ghats as $ghat)
                            <option value="{{ $ghat->id }}">{{ $ghat->name }} ({{ $ghat->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Aarti Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Maha Sandhya Ganga Aarti" value="{{ old('title') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Ceremony Timing Type *</label>
                    <select name="aarti_type" required class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                        <option value="evening">Evening Sandhya Aarti</option>
                        <option value="morning">Morning Dawn Aarti</option>
                        <option value="festival">Festival Special Aarti</option>
                        <option value="special">Special Archana</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Timing Summary *</label>
                    <input type="text" name="timing_summary" required placeholder="e.g. 06:30 PM - 07:45 PM Daily" value="{{ old('timing_summary') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Duration (Minutes) *</label>
                    <input type="number" name="duration_minutes" required value="{{ old('duration_minutes', 60) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Base Price (₹) *</label>
                    <input type="number" step="0.01" name="base_price" required value="{{ old('base_price', 0) }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
                    <span class="text-[10px] text-stone-400">Set 0 for free general darshan passes.</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Banner Image URL</label>
                <input type="text" name="banner_image" placeholder="https://..." value="{{ old('banner_image') }}" 
                       class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Description *</label>
                <textarea name="description" rows="3" required class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Spiritual Significance & Mahima</label>
                <textarea name="significance" rows="2" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('significance') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-stone-700 mb-1">Ritual Steps (Vidhi)</label>
                <textarea name="ritual_steps" rows="3" placeholder="1. Shankhnaad&#10;2. Maha Deepam Aarti&#10;3. Pushpanjali" class="w-full bg-stone-50 border border-stone-300 rounded-xl p-3 text-xs text-stone-900">{{ old('ritual_steps') }}</textarea>
            </div>

            <div class="flex gap-6 pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_featured" value="1" class="rounded-sm text-orange-600">
                    <span>Feature on Homepage</span>
                </label>
                <label class="flex items-center gap-2 text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded-sm text-orange-600">
                    <span>Publish Immediately</span>
                </label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow-xs">
                    Create Aarti Listing
                </button>
                <a href="{{ route('admin.aartis.index') }}" class="px-5 py-2.5 text-xs font-semibold text-stone-600 hover:text-stone-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
