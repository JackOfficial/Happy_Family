<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = JobCategory::withCount('jobs')->latest()->get();
        return view('admin.job_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        JobCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon ?? 'fas fa-folder', // Default icon
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = JobCategory::with('jobs')->findOrFail($id);
        return view('admin.job_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view('admin.job_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = JobCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);

        // Check if category has jobs before deleting to prevent orphaned records
        if ($category->jobs()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category that contains active jobs.');
        }

        $category->delete();

        return redirect()->route('admin.job-categories.index')
            ->with('success', 'Job category deleted successfully.');
    }
}