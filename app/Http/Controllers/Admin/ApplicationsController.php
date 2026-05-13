<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of applications.
     */
    public function index()
    {
        $applications = Application::with(['job', 'country'])
            ->latest()
            ->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Show the detailed view of a specific application.
     */
    public function show($id)
    {
        $application = Application::with(['job', 'country', 'attachments'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update the status of an application (e.g., Shortlisted, Rejected).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,shortlisted,interview,rejected,accepted'
        ]);

        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Application status updated to ' . ucfirst($request->status));
    }

    /**
     * Remove the application (Soft Delete).
     */
    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        
        // Note: SoftDeletes is active on the model, so files remain 
        // until permanent deletion.
        $application->delete();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Application moved to trash.');
    }

    /**
     * Download an attachment (CV/Cover Letter).
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = \App\Models\Attachment::findOrFail($attachmentId);
        
        if (!Storage::exists($attachment->file_path)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        return Storage::download($attachment->file_path, $attachment->file_name);
    }
}