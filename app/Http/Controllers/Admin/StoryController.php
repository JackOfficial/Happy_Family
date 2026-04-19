<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Story, Photo, Document, Organization, Cause};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Storage, DB, Auth};

class StoryController extends Controller
{
    public function index()
    {
        // Eager load everything needed for the index UI
        $stories = Story::with(['organization', 'user', 'photos', 'documents', 'cause'])
                        ->latest()
                        ->paginate(15); 
        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        $causes = Cause::all();
        return view('admin.stories.create', compact('causes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateStory($request);

        return DB::transaction(function () use ($request, $validated) {
            $slug = Str::slug($validated['title']);
            if (Story::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::lower(Str::random(5));
            }
            
            $organization = Organization::first();

            $story = Story::create([
                'title'           => $validated['title'],
                'slug'            => $slug,
                'organization_id' => $organization?->id,
                'user_id'         => Auth::id(), // Primary author
                'created_by'      => Auth::id(), // Tracking
                'cause_id'        => $request->cause_id,
                'summary'         => $validated['summary'],
                'content'         => $validated['content'],
                'status'          => $validated['status'],
            ]);
            
            $this->handleFileUploads($request, $story);

            return redirect()->route('admin.stories.index')->with('success', 'Story created successfully.');
        });
    }

    public function update(Request $request, Story $story)
    {
        $validated = $this->validateStory($request, $story->id);

        return DB::transaction(function () use ($request, $story, $validated) {
            $slug = $story->slug;
            if ($validated['title'] !== $story->title) {
                $slug = Str::slug($validated['title']);
                if (Story::where('slug', $slug)->where('id', '!=', $story->id)->exists()) {
                    $slug .= '-' . Str::lower(Str::random(5));
                }
            }

            $story->update([
                'title'      => $validated['title'],
                'slug'       => $slug,
                'summary'    => $validated['summary'],
                'content'    => $validated['content'],
                'status'     => $validated['status'],
                'cause_id'   => $request->cause_id,
                'updated_by' => Auth::id(),
            ]);

            $this->handleFileUploads($request, $story);

            return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
        });
    }

    public function destroy(Story $story)
    {
        return DB::transaction(function () use ($story) {
            // Cleanup Photos from storage
            foreach ($story->photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
                $photo->delete();
            }

            // Cleanup Documents from storage
            foreach ($story->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }
            
            $story->delete();
            return redirect()->route('admin.stories.index')->with('success', 'Story removed successfully.');
        });
    }

    protected function validateStory(Request $request, $id = null)
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'cause_id'    => 'nullable|exists:causes,id',
            'summary'     => 'nullable|string|max:500',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
            'photos.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);
    }

    protected function handleFileUploads(Request $request, Story $story)
    {
        // Handle Multiple Photos (Gallery)
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('stories/photos', 'public');
                
                $story->photos()->create([
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'caption'     => $story->title,
                    'is_featured' => ($index == 0 && !$story->photos()->where('is_featured', true)->exists()),
                ]);
            }
        }

        // Handle Documents (PDFs/Files)
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
}