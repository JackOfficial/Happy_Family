<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\VolunteerApplicationSent;

class VolunteerController extends Controller
{
    /**
     * Show the volunteer application form.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('volunteers.apply', compact('countries'));
    }

    /**
     * Store a newly created volunteer application.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'dob'        => 'required|date|before:today',
            'country_id' => 'required|exists:countries,id',
            'occupation' => 'nullable|string|max:255',
            'reason'     => 'required|string|min:20',
            // Address fields (for the polymorphic relationship)
            'city'       => 'required|string|max:255',
            'province'   => 'nullable|string|max:255',
        ]);

        try {
            // 2. Database Transaction to ensure both Volunteer and Address are saved
            return DB::transaction(function () use ($validated, $request) {
                
                // Create the Volunteer
                $volunteer = Volunteer::create([
                    'user_id'    => auth()->id(), // Links if they are logged in
                    'country_id' => $validated['country_id'],
                    'name'       => $validated['name'],
                    'email'      => $validated['email'],
                    'phone'      => $validated['phone'],
                    'dob'        => $validated['dob'],
                    'occupation' => $validated['occupation'],
                    'reason'     => $validated['reason'],
                    'status'     => 'pending',
                ]);

                // Create the Polymorphic Address
                $volunteer->address()->create([
                    'city'     => $validated['city'],
                    'province' => $validated['province'],
                    'country'  => Country::find($validated['country_id'])->name,
                ]);

                // 3. Send Notification Email
                Mail::to('musengimanajacques@gmail.com')
                    ->send(new VolunteerApplicationSent($volunteer));

                return redirect()->route('volunteer.thanks')
                    ->with('success', 'Thank you! Your application has been submitted.');
            });

        } catch (\Exception $e) {
            \Log::error('Volunteer Store Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display a thank you page.
     */
    public function thanks()
    {
        return view('volunteers.thanks');
    }
}