<?php

namespace App\Http\Controllers;

use App\Models\Aarti;
use App\Models\AartiSlot;
use App\Models\Ghat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today()->toDateString();

        $featuredAartis = Aarti::with(['ghat', 'upcomingSlots'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $ghats = Ghat::withCount(['aartis' => function ($q) {
            $q->where('is_active', true);
        }])
            ->where('is_active', true)
            ->take(4)
            ->get();

        $cities = Ghat::distinct()->pluck('city');

        $upcomingTodaySlots = AartiSlot::with(['aarti.ghat'])
            ->where('slot_date', $today)
            ->where('status', 'active')
            ->orderBy('start_time')
            ->take(4)
            ->get();

        $stats = [
            'ghats_count' => Ghat::where('is_active', true)->count(),
            'aartis_count' => Aarti::where('is_active', true)->count(),
            'daily_devotees' => 25000,
            'blessings_booked' => 14850,
        ];

        return view('pages.home', compact('featuredAartis', 'ghats', 'cities', 'upcomingTodaySlots', 'stats'));
    }
}
