<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Project, Cause, Organization, Document};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Storage, DB};

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index()
    {
        $projects = Project::with(['project_photo', 'documents', 'cause'])
            ->latest()
            ->paginate(15);

        return view('admin.manage.projects', compact('projects'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        $causes = Cause::all();
        return view('admin.create.project', compact('causes'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        return DB::transaction(function () use ($request, $validated) {
            // Generate unique slug
            $slug = Str::slug($validated['title']);
            if (Project::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::lower(Str::random(5));
            }

            $organization = Organization::first();

            $project = Project::create(array_merge($validated, [
                'slug' => $slug,
                'organization_id' => $organization?->id,
                'progress' => $request->progress ?? 0,
                'status' => $request->status ?? 'active',
            ]));

            $this->handleFileUploads($request, $project);

            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        });
    }

    /**
     * Show the form for editing a project
     */
    public function edit(Project $project)
    {
        $causes = Cause::all();
        $project->load(['project_photo', 'documents', 'cause']);
        return view('admin.edit.project', compact('project', 'causes'));
    }

    /**
     * Update a project
     */
    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request, $project->id);

        return DB::transaction(function () use ($request, $project, $validated) {
            $project->update($validated);

            $this->handleFileUploads($request, $project);

            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        });
    }

    /**
     * Delete a project and its associated files
     */
    public function destroy(Project $project)
    {
        return DB::transaction(function () use ($project) {
            // Delete Featured Photo
            if ($project->project_photo) {
                Storage::disk('public')->delete($project->project_photo->file_path);
                $project->project_photo->delete();
            }

            // Delete Multi-Documents
            foreach ($project->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
                $doc->delete();
            }

            $project->delete();
            return redirect()->route('admin.projects.index')->with('success', 'Project and all files removed.');
        });
    }

    /**
     * Centralized Validation Rules
     */
    protected function validateProject(Request $request, $id = null)
    {
        return $request->validate([
            'title'         => 'required|string|max:255',
            'cause_id'      => 'nullable|exists:causes,id',
            'summary'       => 'nullable|string|max:500',
            'description'   => 'nullable|string',
            'beneficiaries' => 'nullable|integer|min:0',
            'budget'        => 'nullable|numeric|min:0',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'progress'      => 'nullable|integer|between:0,100',
            'status'        => 'in:active,completed,paused,cancelled',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'documents.*'   => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,txt,jpg,jpeg,png|max:10240',
        ]);
    }

    /**
     * File Upload Logic Handler
     */
    protected function handleFileUploads(Request $request, Project $project)
    {
        // 1. Handle Main Project Photo
        if ($request->hasFile('photo')) {
            if ($project->project_photo) {
                Storage::disk('public')->delete($project->project_photo->file_path);
                $project->project_photo->delete();
            }

            $path = $request->file('photo')->store('projects/photos', 'public');
            $project->project_photo()->create([
                'file_path' => $path,
                'caption'   => $project->title,
            ]);
        }

        // 2. Handle Multiple Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('projects/documents', 'public');
                $project->documents()->create([
                    'title'          => $file->getClientOriginalName(),
                    'file_path'      => $path,
                    'file_extension' => $file->getClientOriginalExtension(),
                ]);
            }
        }
    }
}