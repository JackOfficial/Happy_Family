<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Cause;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs for visitors.
     */
    public function index(Request $request)
    {
        // 1. Fetch blogs with their associated Cause and Polymorphic Photo
        // We use latest() to show the newest posts first
        $blogs = Blog::with(['cause', 'blogPhoto', 'user'])
            ->latest()
            ->paginate(9); // 9 per page is standard for a 3x3 grid

        // 2. Fetch all Causes so visitors can filter by "Category"
        $causes = Cause::has('blogs')->get();

        return view('blogs.index', compact('blogs', 'causes'));
    }

    /**
     * Display a specific blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->with(['cause', 'blogPhoto', 'user', 'comments.user'])
            ->firstOrFail();

        // Fetch related blogs from the same cause, excluding the current one
        $relatedBlogs = Blog::where('cause_id', $blog->cause_id)
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }

    /**
     * Filter blogs by a specific Cause (Category).
     */
    public function category(Cause $cause)
    {
        $blogs = Blog::where('cause_id', $cause->id)
            ->with(['blogPhoto', 'user'])
            ->latest()
            ->paginate(9);

        $causes = Cause::has('blogs')->get();
        $currentCategory = $cause->name;

        return view('blogs.index', compact('blogs', 'causes', 'currentCategory'));
    }
}