<?php

namespace App\Http\Controllers;

use App\Models\SportMatch;
use App\Models\HomepageSection;
use Illuminate\View\View;

class SportsController extends Controller
{
    public function index(): View
    {
        $sections = HomepageSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $liveMatches = SportMatch::where('is_active', true)
            ->where('status', 'live')
            ->with('streams')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        $upcomingMatches = SportMatch::where('is_active', true)
            ->where('status', 'upcoming')
            ->with('streams')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        $footballMatches = SportMatch::where('is_active', true)
            ->where('sport_type', 'football')
            ->with('streams')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        $cricketMatches = SportMatch::where('is_active', true)
            ->where('sport_type', 'cricket')
            ->with('streams')
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->get();

        return view('sports.home', compact(
            'sections',
            'liveMatches',
            'upcomingMatches',
            'footballMatches',
            'cricketMatches'
        ));
    }


public function watch(int $id): \Illuminate\View\View
{
    $match = \App\Models\SportMatch::with([
        'streams' => function ($query) {
            $query->where('is_active', true)
                ->orderByDesc('is_primary')
                ->orderBy('sort_order');
        }
    ])
    ->where('is_active', true)
    ->findOrFail($id);

    return view('sports.watch', compact('match'));
}

}
