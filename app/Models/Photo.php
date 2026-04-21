<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Cause;
use App\Models\Project;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the main gallery grid.
     */
    public function index()
    {
        // 1. Fetch photos and eager load the 'imageable' parent (Project or Cause)
        // We use with('imageable') to handle the polymorphic link efficiently.
        $photos = Photo::with('imageable')
            ->latest()
            ->paginate(15);

        // 2. Fetch categories (Causes) to show as filter buttons
        $categories = Cause::orderBy('name')->get();

        return view('gallery.index', [
            'photos' => $photos,
            'categories' => $categories,
            'activeCategory' => null
        ]);
    }

    /**
     * Display gallery filtered by a specific Cause.
     */
    public function filter($slug)
    {
        $category = Cause::where('slug', $slug)->firstOrFail();

        /**
         * 3. Polymorphic Filtering Logic:
         * We want photos where the parent is this Cause, 
         * OR photos where the parent is a Project belonging to this Cause.
         */
        $photos = Photo::where(function ($query) use ($category) {
                // Direct Cause photos
                $query->where(function ($q) use ($category) {
                    $q->where('imageable_type', Cause::class)
                      ->where('imageable_id', $category->id);
                })
                // OR Project photos belonging to this cause
                ->orWhere(function ($q) use ($category) {
                    $q->where('imageable_type', Project::class)
                      ->whereIn('imageable_id', $category->projects->pluck('id'));
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