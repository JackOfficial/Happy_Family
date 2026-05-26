<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    // For regular staff to see THEIR OWN reports
    public function index()
    {
        $reports = auth()->user()->reports()->latest()->paginate(10);
        return view('reports.index', compact('reports'));
    }
}