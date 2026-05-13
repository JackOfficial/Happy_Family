<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Cause;
use App\Models\Project;
use App\Models\Todo; // Ensure this is imported
use App\Models\Volunteer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Counts for Dashboard Stats Cards
        $causes = Cause::where('status', 1)->count();
        $volunteers = Volunteer::count();
        $projectsCount = Project::count();
        
        // Career Stats: Show pending vs total to highlight work needed
        $totalApplications = Application::count();
        $pendingApplications = Application::where('status', 'pending')->count();

        // Improved Progress Logic: Calculate the average progress of all projects
        // We use the 'avg' method directly in the database for better performance
        $averageProgress = Project::avg('progress') ?? 0;

        // Recent Data for the dashboard view
        $recentApplications = Application::with('job')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'causes', 
            'volunteers', 
            'projectsCount', 
            'averageProgress', 
            'totalApplications',
            'pendingApplications',
            'recentApplications'
        ));
    }

    public function addTask(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255'
        ]);

        Todo::create([
            'task' => $request->input('task'),
            'status' => 1 // Assuming 1 is 'active/pending'
        ]);

        return redirect()->back()->with('success', 'Task added successfully.');
    }

    public function taskDone($id)
    {
        // Using findOrFail for better error handling
        $todo = Todo::findOrFail($id);
        $todo->update([
            'status' => 2 // Completed
        ]);

        return redirect()->back()->with('success', 'Task marked as done.');
    }
}