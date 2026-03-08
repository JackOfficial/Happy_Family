<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display all events.
     */
    public function index()
    {
        $events = Event::with(['event_photos', 'documents'])->latest()->get();
        return view('admin.manage.events', compact('events'));
    }

    /**
     * Show form to create new event.
     */
    public function create()
    {
        return view('admin.create.event');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:events,title',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'link' => 'nullable|url',
            'status' => 'required|string|in:active,inactive',
            'photos.*' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|mimes:pdf,doc,docx,zip,xlsx|max:10240',
        ]);
        
        $organization = Organization::first();

        // The 'slug' is automatically generated in the Event Model's booted() method
        $event = Event::create([
            'organization_id' => $organization->id, 
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        // 1. Process Photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('events/photos', 'public');
                $event->event_photos()->create([
                    'file_path' => $path,
                ]);
            }
        }

        // 2. Process Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('events/documents', 'public');
                $event->documents()->create([
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Show form to edit existing event.
     */
    public function edit(Event $event)
    {
        $event->load(['event_photos', 'documents']);
        return view('admin.edit.event', compact('event'));
    }

    /**
     * Update the existing event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:events,title,' . $event->id,
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'status' => 'required|string|in:active,inactive',
            'photos.*' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|mimes:pdf,doc,docx,zip,xlsx|max:10240',
            'removed_photos' => 'nullable|string',
        ]);

        // Update slug if title changes
        if ($event->title !== $request->title) {
            $event->slug = Str::slug($request->title);
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        // 1. Handle Photo Deletions (from your Alpine.js UI)
        if ($request->removed_photos) {
            $ids = explode(',', $request->removed_photos);
            $photos = $event->event_photos()->whereIn('id', $ids)->get();
            foreach ($photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
                $photo->delete();
            }
        }

        // 2. Upload New Photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('events/photos', 'public');
                $event->event_photos()->create(['file_path' => $path]);
            }
        }

        // 3. Upload New Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('events/documents', 'public');
                $event->documents()->create([
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event and all its assets.
     */
    public function destroy(Event $event)
    {
        // Delete Photo Files
        foreach ($event->event_photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
        }

        // Delete Document Files
        foreach ($event->documents as $document) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Note: Database records for photos/docs are handled by the 
        // static::deleting hook we added to the Event model.
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event and associated assets deleted.');
    }
}