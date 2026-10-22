<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aarti;
use App\Models\Ghat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AartiController extends Controller
{
    public function index(): View
    {
        $aartis = Aarti::with(['ghat'])
            ->withCount('slots')
            ->latest()
            ->paginate(15);

        return view('admin.aartis.index', compact('aartis'));
    }

    public function create(): View
    {
        $ghats = Ghat::where('is_active', true)->get();

        return view('admin.aartis.create', compact('ghats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ghat_id' => ['required', 'exists:ghats,id'],
            'title' => ['required', 'string', 'max:255'],
            'aarti_type' => ['required', 'in:evening,morning,festival,special'],
            'timing_summary' => ['required', 'string', 'max:120'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:180'],
            'description' => ['required', 'string'],
            'significance' => ['nullable', 'string'],
            'ritual_steps' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']).'-'.Str::random(4);

        Aarti::create([
            ...$validated,
            'slug' => $slug,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.aartis.index')
            ->with('success', 'Aarti ceremony created successfully.');
    }

    public function edit(Aarti $aarti): View
    {
        $ghats = Ghat::where('is_active', true)->get();

        return view('admin.aartis.edit', compact('aarti', 'ghats'));
    }

    public function update(Request $request, Aarti $aarti): RedirectResponse
    {
        $validated = $request->validate([
            'ghat_id' => ['required', 'exists:ghats,id'],
            'title' => ['required', 'string', 'max:255'],
            'aarti_type' => ['required', 'in:evening,morning,festival,special'],
            'timing_summary' => ['required', 'string', 'max:120'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:180'],
            'description' => ['required', 'string'],
            'significance' => ['nullable', 'string'],
            'ritual_steps' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
        ]);

        $aarti->update([
            ...$validated,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.aartis.index')
            ->with('success', 'Aarti ceremony updated successfully.');
    }

    public function destroy(Aarti $aarti): RedirectResponse
    {
        $aarti->delete();

        return redirect()->route('admin.aartis.index')
            ->with('success', 'Aarti deleted successfully.');
    }
}
