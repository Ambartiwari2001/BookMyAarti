<?php

namespace App\Http\Controllers;

use App\Models\Aarti;
use App\Models\Ghat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AartiController extends Controller
{
    public function index(Request $request): View
    {
        $city = $request->query('city');
        $type = $request->query('type');
        $date = $request->query('date', Carbon::today()->toDateString());

        $query = Aarti::with(['ghat', 'upcomingSlots'])
            ->where('is_active', true);

        if (! empty($city)) {
            $query->whereHas('ghat', function ($q) use ($city) {
                $q->where('city', $city);
            });
        }

        if (! empty($type)) {
            $query->where('aarti_type', $type);
        }

        $aartis = $query->latest('is_featured')->get();
        $cities = Ghat::distinct()->pluck('city');

        return view('pages.aartis.index', compact('aartis', 'cities', 'city', 'type', 'date'));
    }

    public function show(string $slug): View
    {
        $aarti = Aarti::with(['ghat'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $slots = $aarti->slots()
            ->where('slot_date', '>=', Carbon::today()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('slot_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($slot) {
                return $slot->slot_date->format('Y-m-d');
            });

        return view('pages.aartis.show', compact('aarti', 'slots'));
    }
}
