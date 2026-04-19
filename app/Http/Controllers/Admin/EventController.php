<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Event, Organization};
use Illuminate\Support\Facades\{Storage, Auth, DB};
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['event_photos', 'documents'])->latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function downloadPdf(Event $event)
    {
        $eventUrl = route('admin.events.show', $event->slug);
        $event->load(['event_photos', 'documents']);

        $qrcode = base64_encode(QrCode::format('png')
            ->size(150)
            ->margin(1)
            ->generate($eventUrl));

        $pdf = Pdf::loadView('admin.events.pdf', compact('event', 'qrcode'));
        return $pdf->download("Event-Report-{$event->slug}.pdf");
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);

        return DB::transaction(function () use ($request, $validated) {
            $organization = Organization::first();

            $event = Event::create(array_merge($validated, [
                'organization_id' => $organization?->id,
                'created_by' => Auth::id(),
                // Slug is handled by your Model's booted() method
            ]));

            $this->handleFileUploads($request, $event);

            return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
        });
    }

    public function show(Event $event)
    {
        $event->load(['event_photos', 'documents']);
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $event->load(['event_photos', 'documents']);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $this->validateEvent($request, $event->id);

        return DB::transaction(function () use ($request, $event, $validated) {
            if ($event->title !== $validated['title']) {
                $event->slug = Str::slug($validated['title']);
            }

            $event->update(array_merge($validated, [
                'updated_by' => Auth::id(),
            ]));

            // 1. Handle Photo Deletions (Alpine.js UI)
            if ($request->removed_photos) {
                $ids = explode(',', $request->removed_photos);
                $photos = $event->event_photos()->whereIn('id', $ids)->get();
                foreach ($photos as $photo) {
                    Storage::disk('public')->delete($photo->file_path);
                    $photo->delete();
                }
            }

            // 2. Upload New Files
            $this->handleFileUploads($request, $event);

            return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
        });
    }

    public function destroy(Event $event)
    {
        return DB::transaction(function () use ($event) {
            // Delete Physical Files
            foreach ($event->event_photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
            }

            foreach ($event->documents as $document) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Database records deleted via Model booted() hook
            $event->delete();

            return redirect()->route('admin.events.index')->with('success', 'Event and associated assets deleted.');
        });
    }

    /**
     * Internal Validation Logic
     */
    protected function validateEvent(Request $request, $id = null)
    {
        return $request->validate([
            'title'       => 'required|string|max:255|unique:events,title,' . $id,
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'date'        => 'nullable|date',
            'time'        => 'nullable',
            'link'        => 'nullable|url',
            'status'      => 'required|string|in:active,inactive',
            'photos.*'    => 'nullable|image|max:5120',
            'documents.*' => 'nullable|mimes:pdf,doc,docx,zip,xlsx|max:10240',
        ]);
    }

    /**
     * Shared File Handling Logic
     */
    protected function handleFileUploads(Request $request, Event $event)
    {
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('events/photos', 'public');
                $event->event_photos()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                    'caption'   => $event->title,
                ]);
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('events/documents', 'public');
                $event->documents()->create([
                    'title'       => $file->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }
    }
}