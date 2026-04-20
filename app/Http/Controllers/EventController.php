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
        $events = Event::with(['event_photos', 'documents', 'cause'])
            ->whereIn('status', ['upcoming', 'ongoing', 'completed'])
            ->latest()
            ->paginate(15);

        return view('events.index', compact('events'));
    }

    /**
     * Display the specified event.
     */
    public function show($slug)
    {
        // Find by slug or ID as a fallback
        $event = Event::with(['event_photos', 'documents', 'cause'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        return view('events.show', compact('event'));
    }
}
