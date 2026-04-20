<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use Illuminate\Http\Request;

class CauseController extends Controller
{
    /**
     * Display a listing of all active causes.
     */
    public function index()
    {
        // Eager load 'mainPhoto' (polymorphic) to avoid N+1 queries
        // Filter by status = 1 (Active) as defined in your Admin update logic
        $causes = Cause::with(['mainPhoto'])
            ->where('status', 1)
            ->latest()
            ->paginate(9); // 9 works well for a 3x3 grid

        return view('causes.index', compact('causes'));
    }

    /**
     * Display the specified cause and its related impact (Events & Stories).
     */
public function show($slug)
{
    $cause = Cause::with([
        'photos', 
        'mainPhoto', 
        'projects' => fn($q) => $q->latest(),
        'events' => fn($q) => $q->with('photos')->latest(),
        'stories' => fn($q) => $q->with(['mainPhoto', 'photos'])->latest()
    ])
    ->withCount(['events', 'stories', 'projects'])
    ->where('slug', $slug)
    ->where('status', 1)
    ->firstOrFail();

    return view('causes.show', compact('cause'));
}
}