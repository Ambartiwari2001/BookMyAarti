<?php

namespace App\Http\Controllers;

use App\Models\Ghat;
use Illuminate\View\View;

class GhatController extends Controller
{
    public function index(): View
    {
        $ghats = Ghat::with(['aartis' => function ($q) {
            $q->where('is_active', true);
        }])
            ->where('is_active', true)
            ->get();

        return view('pages.ghats.index', compact('ghats'));
    }

    public function show(string $slug): View
    {
        $ghat = Ghat::with(['aartis' => function ($q) {
            $q->where('is_active', true)->with('upcomingSlots');
        }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.ghats.show', compact('ghat'));
    }
}
