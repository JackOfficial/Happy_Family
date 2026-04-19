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
    // We fetch all causes so the user can change the category if needed
    $causes = Cause::all();
    
    // Eager load photos and documents to show them in the edit form
    $story->load(['photos', 'documents']);

    return view('admin.stories.edit', compact('story', 'causes'));
}

    public function store(Request $request)
    {
        $validated = $this->validateStory($request);

        return DB::transaction(function () use ($request, $validated) {
            $organization = Organization::first();

            // Slugs are now handled automatically by the Story Model boot method!
            $story = Story::create([
                ...$validated, // PHP 8.x spread operator for cleaner code
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
            $story->update([
                ...$validated,
                'updated_by' => Auth::id(),
            ]);

            $this->handleFileUploads($request, $story);

            return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
        });
    }

    public function destroy(Story $story)
    {
        return DB::transaction(function () use ($story) {
            // Note: Since you have SoftDeletes, we usually don't delete files here.
            // We only delete files if we 'forceDelete()'. 
            // But if you want them gone immediately:
            $this->cleanupFiles($story);
            
            $story->delete();
            return redirect()->route('admin.stories.index')->with('success', 'Story removed successfully.');
        });
    }

    protected function validateStory(Request $request)
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