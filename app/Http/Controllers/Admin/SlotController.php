<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aarti;
use App\Models\AartiSlot;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlotController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        $aartiId = $request->query('aarti_id');

        $query = AartiSlot::with(['aarti.ghat'])
            ->orderBy('slot_date')
            ->orderBy('start_time');

        if (! empty($date)) {
            $query->where('slot_date', $date);
        }

        if (! empty($aartiId)) {
            $query->where('aarti_id', $aartiId);
        }

        $slots = $query->paginate(20);
        $aartis = Aarti::where('is_active', true)->get();

        return view('admin.slots.index', compact('slots', 'aartis', 'date', 'aartiId'));
    }

    public function create(): View
    {
        $aartis = Aarti::where('is_active', true)->get();

        return view('admin.slots.create', compact('aartis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aarti_id' => ['required', 'exists:aartis,id'],
            'slot_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'reporting_time' => ['nullable', 'string', 'max:100'],
            'total_capacity' => ['required', 'integer', 'min:1'],
            'general_price' => ['required', 'numeric', 'min:0'],
            'vip_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,sold_out,cancelled'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        AartiSlot::create($validated);

        return redirect()->route('admin.slots.index', ['date' => $validated['slot_date']])
            ->with('success', 'Aarti slot created successfully.');
    }

    public function batchGenerate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aarti_id' => ['required', 'exists:aartis,id'],
            'start_date' => ['required', 'date'],
            'days_count' => ['required', 'integer', 'min:1', 'max:60'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'reporting_time' => ['nullable', 'string'],
            'total_capacity' => ['required', 'integer', 'min:10'],
            'general_price' => ['required', 'numeric', 'min:0'],
            'vip_price' => ['required', 'numeric', 'min:0'],
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $createdCount = 0;

        for ($i = 0; $i < (int) $validated['days_count']; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();

            $existing = AartiSlot::where('aarti_id', $validated['aarti_id'])
                ->where('slot_date', $date)
                ->where('start_time', $validated['start_time'])
                ->first();

            if (! $existing) {
                AartiSlot::create([
                    'aarti_id' => $validated['aarti_id'],
                    'slot_date' => $date,
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'reporting_time' => $validated['reporting_time'] ?? '45 minutes prior',
                    'total_capacity' => $validated['total_capacity'],
                    'general_price' => $validated['general_price'],
                    'vip_price' => $validated['vip_price'],
                    'status' => 'active',
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('admin.slots.index', ['date' => $validated['start_date']])
            ->with('success', "Batch generation complete! Created {$createdCount} new slots.");
    }

    public function edit(AartiSlot $slot): View
    {
        $aartis = Aarti::where('is_active', true)->get();

        return view('admin.slots.edit', compact('slot', 'aartis'));
    }

    public function update(Request $request, AartiSlot $slot): RedirectResponse
    {
        $validated = $request->validate([
            'slot_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'reporting_time' => ['nullable', 'string', 'max:100'],
            'total_capacity' => ['required', 'integer', 'min:1'],
            'general_price' => ['required', 'numeric', 'min:0'],
            'vip_price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,sold_out,cancelled'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $slot->update($validated);

        return redirect()->route('admin.slots.index', ['date' => $slot->slot_date->format('Y-m-d')])
            ->with('success', 'Aarti slot updated successfully.');
    }

    public function destroy(AartiSlot $slot): RedirectResponse
    {
        $slot->delete();

        return redirect()->route('admin.slots.index')
            ->with('success', 'Aarti slot removed.');
    }
}
