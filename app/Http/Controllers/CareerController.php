<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Country;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of all active job openings.
     */
    public function index()
    {
        $categories = JobCategory::withCount(['jobs' => function ($query) {
            $query->active(); // Using the 'active' scope we discussed for the Job model
        }])->get();

        $jobs = Job::with('category')
            ->active()
            ->latest()
            ->paginate(10);

        return view('careers.index', compact('jobs', 'categories'));
    }

    /**
     * Display the details of a specific job.
     */
    public function show($slug)
    {
        $job = Job::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $countries = Country::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('careers.show', compact('job', 'countries'));
    }

    /**
     * Note: For the actual submission, since your layout includes Livewire,
     * it is better to handle the form submission inside a Livewire Component 
     * to provide real-time validation and a better UX for applicants.
     */
}