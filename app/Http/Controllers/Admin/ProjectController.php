<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Project, Cause, Organization};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Storage, DB, Auth};

class ProjectController extends Controller
{
    public function index()
    {
        // Eager load project_photos (plural) and documents
        $projects = Project::with(['project_photos', 'documents', 'cause'])
            ->latest()
            ->paginate(15);

        return view('admin.manage.projects', compact('projects'));
    }

    public function create()
    {
        $causes = Cause::all();
        return view('admin.create.project', compact('causes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        return DB::transaction(function () use ($request, $validated) {
            $slug = Str::slug($validated['title']);
            if (Project::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::lower(Str::random(5));
            }

            // Using the first organization as default
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

    public function edit(Project $project)
    {
        $causes = Cause::all();
        $project->load(['project_photos', 'documents', 'cause']);
        return view('admin.edit.project', compact('project', 'causes'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request, $project->id);

        return DB::transaction(function () use ($request, $project, $validated) {
            $project->update($validated);

            $this->handleFileUploads($request, $project);

            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        });
    }

    public function destroy(Project $project)
    {
        return DB::transaction(function () use ($project) {
            // Photos and Documents have SoftDeletes, but we want to clean up storage
            // Your Project model boot method handles the database side, 
            // but physical file deletion should happen here if you want to save space.
            
            foreach ($project->project_photos as $photo) {
                Storage::disk('public')->delete($photo->file_path);
            }

            foreach ($project->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
            }

            $project->delete();
            return redirect()->route('admin.projects.index')->with('success', 'Project removed successfully.');
        });
    }

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
            'status'        => 'in:active,completed,paused,planned,cancelled',
            'photos.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_index'=> 'nullable|integer',
            'documents.*'   => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,txt|max:10240',
        ]);
    }

    protected function handleFileUploads(Request $request, Project $project)
    {
        // 1. Handle Multiple Project Photos
        if ($request->hasFile('photos')) {
            $featuredIndex = $request->input('featured_index', 0);

            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('projects/photos', 'public');
                
                $project->project_photos()->create([
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'is_featured' => ($index == $featuredIndex),
                ]);
            }
        }

        // 2. Handle Multiple Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('projects/documents', 'public');
                
                $project->documents()->create([
                    'title'       => $file->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'uploaded_by' => Auth::id(), // Tracks who uploaded it
                ]);
            }
        }
    }
}