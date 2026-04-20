<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of published success stories.
     */
    public function index()
    {
        // We eager load 'featuredPhoto' to prevent N+1 queries on the grid view
        $stories = Story::with(['featuredPhoto', 'cause'])
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('stories.index', compact('stories'));
    }

    /**
     * Display a specific success story.
     */
    public function show($slug)
    {
        // We load all photos for the gallery and the associated cause/user
        $story = Story::with(['photos', 'documents', 'cause', 'user'])
            ->where('status', 'published')
            ->where(function($query) use ($slug) {
                $query->where('slug', $slug)
                      ->orWhere('id', $slug); // Fallback for old links
            })
            ->firstOrFail();

        // Optional: Get related stories from the same cause to show at the bottom
        $relatedStories = Story::where('cause_id', $story->cause_id)
            ->where('id', '!=', $story->id)
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('stories.show', compact('story', 'relatedStories'));
    }
}