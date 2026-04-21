<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    /**
     * 1. Display the main Projects Hub
     */
    public function index()
    {
        // For now, using static data or fetching from DB
        // $projects = Project::where('is_active', true)->get();
        return view('donations.index');
    }

    /**
     * 2. Show a specific project story
     */
    public function show($slug)
    {
        // $project = Project::where('slug', $slug)->firstOrFail();
        return view('donations.show');
    }

    /**
     * 3. Checkout Page
     */
    public function checkout($project_id = null)
    {
        $selectedProject = null;
        if ($project_id) {
            // $selectedProject = Project::find($project_id);
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
            return redirect()->route('donations.index');
        }

        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
        $response = Http::withToken(config('services.paystack.secret_key'))->get($url);

        if ($response->successful() && $response['data']['status'] == 'success') {
            $data = $response['data'];
            
            // Logic to prevent duplicate entries if webhook already processed it
            $exists = Donation::where('reference', $reference)->exists();
            
            if (!$exists) {
                $this->recordDonation($data);
            }

            return redirect()->route('donations.thank_you')->with([
                'amount' => $data['amount'] / 100,
                'currency' => $data['currency']
            ]);
        }

        return redirect()->route('donations.index')->with('error', 'Payment verification failed.');
    }

    /**
     * 5. Thank You Page
     */
    public function thankYou()
    {
        return view('donations.thank-you');
    }

    /**
     * 6. Paystack Webhook (The "Silent" Safety Net)
     */
    public function handleWebhook(Request $request)
    {
        // Only accept requests from Paystack IPs for security
        // In production, verify the signature: $request->header('x-paystack-signature')
        
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
     * Private helper to save donation to DB
     */
    private function recordDonation($data)
    {
        // Donation::create([
        //     'name' => $data['metadata']['donor_name'] ?? 'Anonymous',
        //     'email' => $data['customer']['email'],
        //     'amount' => $data['amount'] / 100,
        //     'currency' => $data['currency'],
        //     'reference' => $data['reference'],
        //     'status' => 'completed',
        //     'project_id' => $data['metadata']['project_id'] ?? null,
        // ]);

        // Trigger Thank You Email here
        // Mail::to($data['customer']['email'])->send(new ThankYouDonation($data));
    }
}