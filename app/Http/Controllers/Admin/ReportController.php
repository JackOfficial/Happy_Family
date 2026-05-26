<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // For Admin/Management to see EVERYTHING
    public function index()
    {
        // Only users with 'view all reports' permission can enter
        if (!auth()->user()->can('view all reports')) {
            abort(403);
        }

        $reports = Report::with(['user', 'reportable'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }
}
