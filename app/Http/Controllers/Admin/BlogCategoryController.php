<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = BlogCategory::with('categoryPhoto')->latest()->paginate(15);
        return view('admin.blog_categories.index', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:blog_categories,name',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Create the category (the 'photo' column in migration will remain null/empty)
            $category = BlogCategory::create($validated);

            // Handle the Polymorphic Photo
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('uploads/categories', 'public');
                $category->categoryPhoto()->create([
                    'file_path' => $path
                ]);
            }

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Category created successfully.');
        });
    }

    /**
     * Show the form for editing.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $blogCategory->load('categoryPhoto');
        return view('admin.blog_categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        return DB::transaction(function () use ($request, $blogCategory, $validated) {
            $validated['slug'] = Str::slug($validated['name']);
            $blogCategory->update($validated);

            if ($request->hasFile('photo')) {
                // Remove old polymorphic photo if it exists
                if ($blogCategory->categoryPhoto) {
                    Storage::disk('public')->delete($blogCategory->categoryPhoto->file_path);
                    $blogCategory->categoryPhoto()->delete();
                }

                $path = $request->file('photo')->store('uploads/categories', 'public');
                $blogCategory->categoryPhoto()->create([
                    'file_path' => $path
                ]);
            }

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Category updated successfully.');
        });
    }

    /**
     * Remove the specified category (Soft Delete).
     */
    public function destroy(BlogCategory $blogCategory)
    {
        return DB::transaction(function () use ($blogCategory) {
            // We usually keep the photo file on SoftDelete, 
            // but if you want to purge it, do it here.
            $blogCategory->delete();

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Category moved to trash.');
        });
    }
}