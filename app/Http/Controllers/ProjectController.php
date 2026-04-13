<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display the list of all projects
     */
    public function index()
    {
        // Use 'causes' (plural) and the smart featured image logic
        $projects = Project::with(['causes', 'project_photos'])
            ->latest()
            ->paginate(12); // Added pagination for better performance

        return view('projects', compact('projects')); 
    }

    /**
     * Display a single project by its slug
     */
    public function show($slug)
    {
        // 1. Fetch project by slug with all necessary relationships
        $project = Project::with(['project_photos', 'documents', 'causes'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        // 2. Fetch "Other Projects" related by sharing the same causes
        // We get the IDs of the current project's causes to find matches
        $causeIds = $project->causes->pluck('id');

        $otherProjects = Project::with('project_photos')
            ->whereHas('causes', function($query) use ($causeIds) {
                $query->whereIn('causes.id', $causeIds);
            })
            ->where('id', '!=', $project->id)
            ->latest()
            ->take(3)
            ->get();
    
        // 3. Fetch all categories for a sidebar if needed
        $causes = Cause::all(); 
         
        return view('project', compact('project', 'otherProjects', 'causes'));  
    }
}