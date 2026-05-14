<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Cause;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        // Added pagination for better performance
        $blogs = Blog::with(['blogPhoto', 'cause', 'user'])->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $causes = Cause::all();
        return view('admin.blogs.create', compact('causes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'cause_id' => 'required|exists:causes,id',
            'content'  => 'required|string',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $validated['user_id'] = auth()->id();
            
            // Ensure unique slug
            $slug = Str::slug($validated['title']);
            $count = Blog::where('slug', 'LIKE', "{$slug}%")->count();
            $validated['slug'] = $count ? "{$slug}-{$count}" : $slug;

            $blog = Blog::create($validated);

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('uploads/blogs', 'public');
                $blog->blogPhoto()->create(['file_path' => $path]);
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Blog published successfully.');
        });
    }

    public function edit(Blog $blog)
    {
        $causes = Cause::all();
        $blog->load('blogPhoto');
        return view('admin.blogs.edit', compact('blog', 'causes'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'cause_id' => 'required|exists:causes,id',
            'content'  => 'required|string',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        return DB::transaction(function () use ($request, $blog, $validated) {
            // Only update slug if title changed
            if ($blog->title !== $validated['title']) {
                $slug = Str::slug($validated['title']);
                $count = Blog::where('slug', 'LIKE', "{$slug}%")->where('id', '<>', $blog->id)->count();
                $validated['slug'] = $count ? "{$slug}-{$count}" : $slug;
            }

            $blog->update($validated);

            if ($request->hasFile('photo')) {
                // Delete old file
                if ($blog->blogPhoto) {
                    Storage::disk('public')->delete($blog->blogPhoto->file_path);
                    $blog->blogPhoto()->delete();
                }

                $path = $request->file('photo')->store('uploads/blogs', 'public');
                $blog->blogPhoto()->create(['file_path' => $path]);
            }

            return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
        });
    }

    public function destroy(Blog $blog)
    {
        return DB::transaction(function () use ($blog) {
            if ($blog->blogPhoto) {
                Storage::disk('public')->delete($blog->blogPhoto->file_path);
                $blog->blogPhoto()->delete();
            }

            $blog->delete();

            return redirect()->route('admin.blogs.index')->with('success', 'Blog removed safely.');
        });
    }
}