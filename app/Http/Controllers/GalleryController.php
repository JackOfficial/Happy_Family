<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Cause;
use App\Models\Project;
use App\Models\Event;
use App\Models\Story;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the main gallery grid with all polymorphic photos.
     */
    public function index()
    {
        // Fetch photos and eager load the 'imageable' parent (Cause, Project, Event, Story, or Team)
        $photos = Photo::with('imageable')
            ->latest()
            ->paginate(15);

        // Fetch all causes for the filter navigation
        $categories = Cause::orderBy('name')->get();

        return view('gallery.index', [
            'photos' => $photos,
            'categories' => $categories,
            'activeCategory' => null
        ]);
    }

    /**
     * Display a detailed focus view of a single photo.
     */
    public function show(Photo $photo)
    {
        $photo->load('imageable');
        return view('gallery.show', compact('photo'));
    }

    /**
     * Advanced Polymorphic Filtering:
     * Pulls photos belonging to the Cause OR any children related to that Cause.
     */
    public function filter($slug)
    {
        $category = Cause::where('slug', $slug)->firstOrFail();

        $photos = Photo::where(function ($query) use ($category) {
            // 1. Photos directly linked to the Cause
            $query->where(function ($q) use ($category) {
                $q->where('imageable_type', Cause::class)
                  ->where('imageable_id', $category->id);
            })
            // 2. Photos linked to Projects belonging to this Cause
            ->orWhere(function ($q) use ($category) {
                $q->where('imageable_type', Project::class)
                  ->whereIn('imageable_id', $category->projects()->pluck('id'));
            })
            // 3. Photos linked to Events belonging to this Cause
            ->orWhere(function ($q) use ($category) {
                $q->where('imageable_type', Event::class)
                  ->whereIn('imageable_id', $category->events()->pluck('id'));
            })
            // 4. Photos linked to Stories belonging to this Cause
            ->orWhere(function ($q) use ($category) {
                $q->where('imageable_type', Story::class)
                  ->whereIn('imageable_id', $category->stories()->pluck('id'));
            });
        })
        ->with('imageable')
        ->latest()
        ->paginate(15);

        $categories = Cause::orderBy('name')->get();

        return view('gallery.index', [
            'photos' => $photos,
            'categories' => $categories,
            'activeCategory' => $category
        ]);
    }
}