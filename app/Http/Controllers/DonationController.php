<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Donation;
use App\Models\Cause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    /**
     * 1. Display the main Projects Hub
     */
    public function index()
    {
        $projects = Project::with(['causes', 'project_photos'])
            ->latest()
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    /**
     * 2. Show a specific project story
     */
    public function show($slug)
    {
        $project = Project::with(['project_photos', 'documents', 'causes'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        $causeIds = $project->causes->pluck('id');

        $otherProjects = Project::with('project_photos')
            ->whereHas('causes', function($query) use ($causeIds) {
                $query->whereIn('causes.id', $causeIds);
            })
            ->where('id', '!=', $project->id)
            ->latest()
            ->take(3)
            ->get();
    
        $causes = Cause::all(); 
         
        return view('projects.show', compact('project', 'otherProjects', 'causes'));  
    }

    /**
     * 3. Checkout Page
     */
    public function checkout($project_id = null)
    {
        $selectedProject = null;
        if ($project_id) {
            $selectedProject = Project::with('project_photos')->find($project_id);
        }
        
        return view('donations.checkout', compact('selectedProject'));
    }

    /**
     * 4. Verification after Redirect
     */
    public function handleSuccess(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('projects.index');
        }

        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
        $response = Http::withToken(config('services.paystack.secret_key'))->get($url);

        if ($response->successful() && $response['data']['status'] == 'success') {
            $data = $response['data'];
            
            // Check if donation already recorded (via Webhook)
            $donation = Donation::where('reference', $reference)->first();
            
            if (!$donation) {
                $donation = $this->recordDonation($data);
            }

            return redirect()->route('donations.thank_you')->with([
                'amount' => $data['amount'] / 100,
                'currency' => $data['currency']
            ]);
        }

        return redirect()->route('projects.index')->with('error', 'Payment verification failed.');
    }

    /**
     * 5. Thank You Page
     */
    public function thankYou()
    {
        return view('donations.thank-you');
    }

    /**
     * 6. Paystack Webhook (The Safety Net)
     */
    public function handleWebhook(Request $request)
    {
        // For production: Verify Paystack signature here
        $event = $request->input('event');

        if ($event == 'charge.success') {
            $data = $request->input('data');
            $reference = $data['reference'];

            $exists = Donation::where('reference', $reference)->exists();
            if (!$exists) {
                $this->recordDonation($data);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Private helper to save donation and update Project total
     */
    private function recordDonation($data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create Donation Record
            $donation = Donation::create([
                'name'       => $data['metadata']['donor_name'] ?? 'Anonymous Donor',
                'email'      => $data['customer']['email'],
                'amount'     => $data['amount'] / 100,
                'currency'   => $data['currency'],
                'reference'  => $data['reference'],
                'status'     => 'completed',
                'project_id' => $data['metadata']['project_id'] ?? null,
            ]);

            // 2. Update Project Progress (Atomic increment)
            if ($donation->project_id) {
                $project = Project::find($donation->project_id);
                if ($project) {
                    $project->increment('raised_amount', $donation->amount);
                }
            }

            // 3. Optional: Trigger Email
            // Mail::to($donation->email)->send(new ThankYouDonation($donation));

            return $donation;
        });
    }
}