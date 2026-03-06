<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CauseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Using with('mainPhoto') to prevent N+1 query issues
        $causes = Cause::with('mainPhoto')->orderBy('id', 'DESC')->get();
        return view('admin.manage.causes', compact('causes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create.cause');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cause'       => 'required|string|max:255|unique:causes,name',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,svg|max:5120',
        ]);

        // 1. Create the Cause
        $cause = Cause::create([
            'name'        => $validated['cause'],
            'description' => $validated['description'],
            'status'      => 1, // 1 for Active/Visible
        ]);

        // 2. Handle the Polymorphic Photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('causes', 'public');
            
            $cause->photos()->create([
                'file_path' => $path,
                'caption'   => $validated['cause'],
            ]);
        }

        return redirect()
            ->route('admin.causes.index')
            ->with('success', 'Impact Area "' . $cause->name . '" has been created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cause $cause)
    {
        // Load the relationship for the preview in the edit form
        $cause->load('mainPhoto');
        return view('admin.edit.cause', compact('cause'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cause $cause)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:causes,name,' . $cause->id,
            'description' => 'nullable|string',
            'status'      => 'required|boolean',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,svg|max:5120'
        ]);
        
        // 1. Update text data
        $cause->update([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ]);
        
        // 2. Handle Photo Swap
        if ($request->hasFile('photo')) {
            // Delete old physical file and database record
            if ($cause->mainPhoto) {
                Storage::disk('public')->delete($cause->mainPhoto->file_path);
                $cause->mainPhoto()->delete();
            }

            // Store new file and create record
            $path = $request->file('photo')->store('causes', 'public');
            $cause->photos()->create([
                'file_path' => $path,
                'caption'   => $validated['name']
            ]);
        }
        
        return redirect()
            ->route('admin.causes.index')
            ->with('success', 'Cause "' . $cause->name . '" updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cause $cause)
    {
        // 1. Clean up physical storage for all related polymorphic photos
        foreach ($cause->photos as $photo) {
            Storage::disk('public')->delete($photo->file_path);
            $photo->delete(); // Delete the record
        }

        // 2. Delete the cause (handles SoftDeletes if enabled in model)
        $cause->delete();

        return redirect()
            ->route('admin.causes.index')
            ->with('success', 'Cause and associated media deleted successfully!');
    }
}