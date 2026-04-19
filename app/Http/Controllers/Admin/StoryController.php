<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Story, Photo, Document, Organization, Cause};
use Illuminate\Support\Facades\{Storage, DB, Auth};

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['organization', 'user', 'cause', 'featuredPhoto'])
                        ->latest()
                        ->paginate(15); 
        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        $causes = Cause::all();
        return view('admin.stories.create', compact('causes'));
    }

    public function edit(Story $story)
    {
        $causes = Cause::all();
        $story->load(['photos', 'documents']);

        return view('admin.stories.edit', compact('story', 'causes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStory($request);

        return DB::transaction(function () use ($request, $validated) {
            $organization = Organization::first();

            $story = Story::create([
                ...$validated,
                'organization_id' => $organization?->id,
                'user_id'         => Auth::id(),
                'created_by'      => Auth::id(),
            ]);
            
            $this->handleFileUploads($request, $story);

            return redirect()->route('admin.stories.index')->with('success', 'Story created successfully.');
        });
    }

    public function update(Request $request, Story $story)
    {
        $validated = $this->validateStory($request);

        return DB::transaction(function () use ($request, $story, $validated) {
            // 1. Update basic fields
            $story->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            // 2. Process removals (Updated for Polymorphic Relationship)
            $this->processRemovals($request, $story);

            // 3. Update Featured Photo ID
            if ($request->filled('featured_photo_id')) {
                $story->photos()->update(['is_featured' => false]);
                $story->photos()->where('id', $request->featured_photo_id)->update(['is_featured' => true]);
            }

            // 4. Handle new uploads
            $this->handleFileUploads($request, $story);

            return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
        });
    }

    public function destroy(Story $story)
    {
        return DB::transaction(function () use ($story) {
            $this->cleanupFiles($story);
            $story->delete();
            return redirect()->route('admin.stories.index')->with('success', 'Story removed successfully.');
        });
    }

    protected function validateStory(Request $request)
    {
        return $request->validate([
            'title'             => 'required|string|max:255',
            'cause_id'          => 'nullable|exists:causes,id',
            'summary'           => 'nullable|string|max:500',
            'content'           => 'required|string',
            'status'            => 'required|in:draft,published,archived',
            'photos.*'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'documents.*'       => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
            'remove_photos'     => 'nullable|array',
            'remove_documents'  => 'nullable|array',
            'featured_photo_id' => 'nullable|integer',
        ]);
    }

    /**
     * Syncs the database and filesystem with Alpine.js removal requests
     * Uses Polymorphic ID and Type for accurate filtering
     */
    protected function processRemovals(Request $request, Story $story)
    {
        // Remove Documents
        if ($request->has('remove_documents')) {
            $docs = Document::whereIn('id', $request->remove_documents)
                ->where('documentable_id', $story->id)
                ->where('documentable_type', Story::class)
                ->get();

            foreach ($docs as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }
        }

        // Remove Photos
        if ($request->has('remove_photos')) {
            $photos = Photo::whereIn('id', $request->remove_photos)
                ->where('photoable_id', $story->id)
                ->where('photoable_type', Story::class)
                ->get();

            foreach ($photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
                $photo->delete();
            }
        }
    }

    protected function handleFileUploads(Request $request, Story $story)
    {
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('stories/photos', 'public');
                
                $story->photos()->create([
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'caption'     => $story->title,
                    'is_featured' => !$story->photos()->where('is_featured', true)->exists(),
                ]);
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('stories/documents', 'public');
                
                $story->documents()->create([
                    'title'       => $file->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }
    }

    public function show(Story $story)
{
    $story->load(['photos', 'documents', 'cause', 'user']);
    return view('admin.stories.show', compact('story'));
}

    private function cleanupFiles(Story $story)
    {
        foreach ($story->photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
            $photo->delete();
        }
        foreach ($story->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
        }
    }
}