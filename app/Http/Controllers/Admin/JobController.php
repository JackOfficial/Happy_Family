<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of the vacancies.
     */
    public function index()
    {
        $jobs = Job::with('category')
            ->withCount('applications')
            ->latest()
            ->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new vacancy.
     */
    public function create()
    {
        $categories = JobCategory::all();
        return view('admin.jobs.create', compact('categories'));
    }

    /**
     * Store a newly created vacancy in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required',
            'location' => 'required|string',
            'type' => 'required|in:Full-time,Part-time,Contract,Volunteer,Internship',
            'deadline' => 'nullable|date|after:today',
        ]);

        Job::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'job_category_id' => $request->job_category_id,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'location' => $request->location,
            'type' => $request->type,
            'deadline' => $request->deadline,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job vacancy posted successfully.');
    }

    /**
     * Display the specific job details.
     */
    public function show(string $id)
    {
        $job = Job::with(['category', 'applications'])->findOrFail($id);
        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the vacancy.
     */
    public function edit(string $id)
    {
        $job = Job::findOrFail($id);
        $categories = JobCategory::all();
        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    /**
     * Update the vacancy in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'job_category_id' => 'required|exists:job_categories,id',
            'description' => 'required',
            'type' => 'required|in:Full-time,Part-time,Contract,Volunteer,Internship',
        ]);

        $job->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $job->id, // Persistent slug using ID
            'job_category_id' => $request->job_category_id,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'location' => $request->location,
            'type' => $request->type,
            'deadline' => $request->deadline,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the vacancy (Soft Delete).
     */
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);
        $job->delete(); // Leverages SoftDeletes from migration

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job moved to trash.');
    }
}