<?php

namespace App\Http\Controllers;

use App\Models\ProjectPhoto;
use App\Models\Cause;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the main gallery grid.
     */
    public function index()
    {
        // 1. Fetch photos with their associated projects 
        // We use with('project') to prevent N+1 query issues
        $photos = ProjectPhoto::with(['project.causes'])
            ->latest()
            ->paginate(15);

        // 2. Fetch categories (Causes) that actually have photos
        // This ensures your filter buttons don't lead to empty pages
        $categories = Cause::whereHas('projects.project_photos')->get();

        return view('gallery.index', [
            'photos' => $photos,
            'categories' => $categories,
            'activeCategory' => null
        ]);
    }

    /**
     * Display gallery filtered by a specific category (Cause).
     */
    public function filter($slug)
    {
        $category = Cause::where('slug', $slug)->firstOrFail();

        // Fetch photos belonging to projects under this specific cause
        $photos = ProjectPhoto::whereHas('project.causes', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
        ->with('project')
        ->latest()
        ->paginate(15);

        $categories = Cause::whereHas('projects.project_photos')->get();

        return view('gallery.index', [
            'photos' => $photos,
            'categories' => $categories,
            'activeCategory' => $category
        ]);
    }
}