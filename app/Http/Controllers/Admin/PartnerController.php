<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display a listing of the partners.
     */
    public function index(): View
    {
        // Using paginate instead of get() for better admin performance as the list grows
        $partners = Partner::with('organization')->latest()->paginate(15);
        
        return view('admin.manage.partners', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create(): View
    {
        return view('admin.create.partner');
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'website'     => 'nullable|url|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        // Ensuring we have an organization link, defaults to 1
        $validated['organization_id'] = $request->organization_id ?? 1;

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner successfully onboarded.');
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return view('admin.edit.partner', compact('partner'));
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'website'     => 'nullable|url|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old file if a new one is uploaded
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner details updated successfully.');
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy(Partner $partner): RedirectResponse
    {
        // Cleanup storage
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner has been removed.');
    }
}