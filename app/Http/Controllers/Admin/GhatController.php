<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ghat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GhatController extends Controller
{
    public function index(): View
    {
        $ghats = Ghat::withCount('aartis')->latest()->paginate(15);

        return view('admin.ghats.index', compact('ghats'));
    }

    public function create(): View
    {
        return view('admin.ghats.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'river' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string'],
            'reporting_instructions' => ['nullable', 'string'],
            'guidelines' => ['nullable', 'string'],
            'contact_helpline' => ['nullable', 'string', 'max:50'],
        ]);

        $slug = Str::slug($validated['name'].'-'.$validated['city']);

        Ghat::create([
            ...$validated,
            'slug' => $slug,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.ghats.index')
            ->with('success', 'Ghat location added successfully.');
    }

    public function edit(Ghat $ghat): View
    {
        return view('admin.ghats.edit', compact('ghat'));
    }

    public function update(Request $request, Ghat $ghat): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'river' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string'],
            'reporting_instructions' => ['nullable', 'string'],
            'guidelines' => ['nullable', 'string'],
            'contact_helpline' => ['nullable', 'string', 'max:50'],
        ]);

        $ghat->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.ghats.index')
            ->with('success', 'Ghat location updated successfully.');
    }

    public function destroy(Ghat $ghat): RedirectResponse
    {
        $ghat->delete();

        return redirect()->route('admin.ghats.index')
            ->with('success', 'Ghat removed successfully.');
    }
}
