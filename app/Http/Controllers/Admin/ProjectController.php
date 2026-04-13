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
        $projects = Project::with(['project_photos', 'documents', 'causes'])
            ->latest()
            ->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $causes = Cause::all();
        return view('admin.projects.create', compact('causes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        return DB::transaction(function () use ($request, $validated) {
            $slug = Str::slug($validated['title']);
            if (Project::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::lower(Str::random(5));
            }

            $organization = Organization::first();

            // Handle the Many-to-Many or Single Cause relationship
            // If cause_ids is an array from checkboxes, we remove it from the main create
            $projectData = collect($validated)->except(['cause_ids', 'photos', 'documents', 'featured_index'])->toArray();

            $project = Project::create(array_merge($projectData, [
                'slug' => $slug,
                'organization_id' => $organization?->id,
                'progress' => $request->progress ?? 0,
                'status' => $request->status ?? 'Upcoming', // Default to your dropdown value
                'created_by' => Auth::id(),
            ]));

            // Sync Mission Categories if using checkboxes
            if ($request->has('cause_ids')) {
                $project->causes()->sync($request->cause_ids);
            }

            $this->handleFileUploads($request, $project);

            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
        });
    }

    public function edit(Project $project)
    {
        $causes = Cause::all();
        $project->load(['project_photos', 'documents', 'causes']);
        return view('admin.projects.edit', compact('project', 'causes'));
    }

    public function show(Project $project)
    {
        // Eager load all relationships to avoid N+1 issues in the show blade
        $project->load(['project_photos', 'documents', 'causes']);

        return view('admin.projects.show', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request, $project->id);

        return DB::transaction(function () use ($request, $project, $validated) {
            $projectData = collect($validated)->except(['cause_ids', 'photos', 'documents', 'featured_index'])->toArray();
            
            $project->update(array_merge($projectData, [
              'updated_by' => Auth::id(),
            ]));

            if ($request->has('cause_ids')) {
                $project->causes()->sync($request->cause_ids);
            }

            $this->handleFileUploads($request, $project);

            return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
        });
    }

    public function destroy(Project $project)
    {
        return DB::transaction(function () use ($project) {
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
            'title'          => 'required|string|max:255',
            'cause_ids'      => 'nullable|array',
            'cause_ids.*'    => 'exists:causes,id',
            'summary'        => 'nullable|string|max:500',
            'description'    => 'nullable|string',
            'budget'         => 'nullable|numeric|min:0',
            'start_date'     => 'nullable|date',
            'duration'       => 'nullable|string|max:100', // Added Duration field
            'progress'       => 'nullable|integer|between:0,100',
            'status'         => 'required|in:Upcoming,Ongoing,Completed', // Updated to match UI
            'photos.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_index' => 'nullable|integer',
            'documents.*'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,txt|max:10240',
        ]);
    }

    protected function handleFileUploads(Request $request, Project $project)
    {
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

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('projects/documents', 'public');
                
                $project->documents()->create([
                    'title'       => $file->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_type'   => $file->getClientOriginalExtension(),
                    'file_size'   => $file->getSize(),
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }
    }
}