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
        'events' => function($query) {
            // Eager load event photos so the thumbnails work efficiently
            $query->with('photos')->whereIn('status', ['upcoming', 'ongoing'])->latest()->take(3);
        },
        'stories' => function($query) {
            // Eager load story photos/mainPhoto
            $query->with(['mainPhoto', 'photos'])->latest()->take(3);
        }
    ])
    /* Add this to get accurate totals for the 'Vision' card 
       even if we only 'take(3)' for the display list 
    */
    ->withCount(['events', 'stories']) 
    ->where('slug', $slug)
    ->where('status', 1) // Ensure we don't show disabled causes via URL guessing
    ->firstOrFail();

    return view('causes.show', compact('cause'));
}
}