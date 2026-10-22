<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aarti;
use App\Models\AartiSlot;
use App\Models\Booking;
use App\Models\Ghat;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today()->toDateString();

        $todayBookings = Booking::whereHas('slot', function ($q) use ($today) {
            $q->where('slot_date', $today);
        })->where('booking_status', '!=', 'cancelled')->count();

        $todayDevotees = Booking::whereHas('slot', function ($q) use ($today) {
            $q->where('slot_date', $today);
        })->where('booking_status', '!=', 'cancelled')->sum('devotee_count');

        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_amount');

        $totalGhats = Ghat::count();
        $totalAartis = Aarti::count();

        $todaySlots = AartiSlot::with(['aarti.ghat'])
            ->where('slot_date', $today)
            ->orderBy('start_time')
            ->get();

        $recentBookings = Booking::with(['slot.aarti.ghat', 'devotees'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'todayBookings',
            'todayDevotees',
            'totalRevenue',
            'totalGhats',
            'totalAartis',
            'todaySlots',
            'recentBookings'
        ));
    }
}
