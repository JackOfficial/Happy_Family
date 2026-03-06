<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\Photo;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        // Added pagination - better for performance as stories grow
        $stories = Story::with(['organization', 'user', 'photo'])
                        ->latest()
                        ->paginate(15); 
        return view('admin.manage.stories', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.create.story');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published,archived',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Increased to 5MB
        ]);

        $slug = Str::slug($request->title);
        if (Story::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4)); // More elegant than time()
        }
        
        // Using a fallback for organization if none exists to prevent crashes
        $organization = Organization::first() ?? new Organization(['id' => 1]);

        $story = Story::create([
            'title'           => $validated['title'],
            'slug'            => $slug,
            'organization_id' => $organization->id,
            'user_id'         => auth()->id(),
            'summary'         => $validated['summary'],
            'content'         => $validated['content'],
            'status'          => $validated['status'],
        ]);
        
        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('stories', 'public');
            $story->photo()->create([
                'file_path' => $filePath,
                'caption'   => $validated['title'],
            ]);
        }

        return redirect()->route('admin.stories.index')->with('success', 'Story created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
       return view('admin.stories.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        return view('admin.edit.story', compact('story'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published,archived',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Logic fix: Only update slug if the title actually changed
        $slug = $story->slug;
        if ($validated['title'] !== $story->title) {
            $slug = Str::slug($validated['title']);
            if (Story::where('slug', $slug)->where('id', '!=', $story->id)->exists()) {
                $slug .= '-' . Str::lower(Str::random(4));
            }
        }

        $story->update([
            'title'   => $validated['title'],
            'slug'    => $slug,
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'status'  => $validated['status'],
        ]);

        if ($request->hasFile('photo')) {
            if ($story->photo) {
                Storage::disk('public')->delete($story->photo->file_path);
                $story->photo()->delete();
            }

            $filePath = $request->file('photo')->store('stories', 'public');
            $story->photo()->create([
                'file_path' => $filePath,
                'caption'   => $validated['title'],
            ]);
        }

        return redirect()->route('admin.stories.index')->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Story $story)
    {
        // polymorphic cleanup is good!
        if ($story->photo) {
            Storage::disk('public')->delete($story->photo->file_path);
            $story->photo->delete();
        }
        
        $story->delete();
        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully.');
    }
}
