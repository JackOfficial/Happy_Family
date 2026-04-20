<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        // Aligned with Admin logic: using 'photos' (polymorphic) instead of 'event_photos'
        // and eager loading the featured photo for the grid view.
        $events = Event::with(['photos', 'featuredPhoto', 'cause'])
            ->whereIn('status', ['upcoming', 'ongoing', 'completed', 'published'])
            ->latest()
            ->paginate(12); // 12 works better for 3-column grids

        return view('events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show($slug)
    {
        // Find by slug or ID as a fallback, ensuring we load the correct relationships
        $event = Event::with(['photos', 'documents', 'cause', 'creator'])
            ->where(function($query) use ($slug) {
                $query->where('slug', $slug)
                      ->orWhere('id', $slug);
            })
            ->firstOrFail();

        // Get 3 related events from the same cause to display at the bottom
        $relatedEvents = Event::where('cause_id', $event->cause_id)
            ->where('id', '!=', $event->id)
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }
}