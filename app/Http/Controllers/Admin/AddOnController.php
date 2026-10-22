<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddOn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AddOnController extends Controller
{
    public function index(): View
    {
        $addOns = AddOn::latest()->paginate(15);

        return view('admin.add-ons.index', compact('addOns'));
    }

    public function create(): View
    {
        return view('admin.add-ons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $slug = Str::slug($validated['name']).'-'.Str::random(3);

        AddOn::create([
            ...$validated,
            'slug' => $slug,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.add-ons.index')
            ->with('success', 'Spiritual offering added successfully.');
    }

    public function edit(AddOn $addOn): View
    {
        return view('admin.add-ons.edit', compact('addOn'));
    }

    public function update(Request $request, AddOn $addOn): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $addOn->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.add-ons.index')
            ->with('success', 'Offering updated successfully.');
    }

    public function destroy(AddOn $addOn): RedirectResponse
    {
        $addOn->delete();

        return redirect()->route('admin.add-ons.index')
            ->with('success', 'Offering removed successfully.');
    }
}
