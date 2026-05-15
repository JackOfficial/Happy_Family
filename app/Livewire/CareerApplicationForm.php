<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application;
use App\Models\Country; // Ensure this is imported
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CareerApplicationForm extends Component
{
    use WithFileUploads;

    // Data passed from parent or loaded in mount
    public $job;
    public $countries;

    // Form fields matching your Application Migration/Model
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $country_id;
    public $gender;
    public $linkedin_url;
    public $additional_notes;
    
    // File upload
    public $cv;

    /**
     * Initialize the component
     */
    public function mount($job, $countries = null)
    {
        $this->job = $job;
        
        // If countries aren't passed from the parent, load active ones here
        $this->countries = $countries ?? Country::where('is_active', true)->orderBy('name')->get();
    }

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:25',
            'country_id'   => 'required|exists:countries,id',
            'gender'       => 'nullable|string',
            'linkedin_url' => 'nullable|url',
            'additional_notes' => 'nullable|string|max:2000',
            'cv'           => 'required|mimes:pdf,doc,docx|max:10240', // 10MB limit
        ];
    }

    /**
     * Process Application Submission
     */
    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // 1. Create Application
                $application = Application::create([
                    'job_id'           => $this->job->id,
                    'country_id'       => $this->country_id,
                    'first_name'       => $this->first_name,
                    'last_name'        => $this->last_name,
                    'email'            => $this->email,
                    'phone'            => $this->phone,
                    'gender'           => $this->gender,
                    'linkedin_url'     => $this->linkedin_url,
                    'additional_notes' => $this->additional_notes,
                    'status'           => 'pending',
                ]);

                // 2. Handle Polymorphic Attachment (CV)
                if ($this->cv) {
                    // Store on private disk for security
                    $path = $this->cv->store('applications/cvs', 'private');

                    $application->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $this->cv->getClientOriginalName(),
                        'file_type' => 'cv',
                    ]);
                }
            });

            session()->flash('message', "Your application for {$this->job->title} was submitted successfully!");
            
            // Reset form fields
            $this->reset([
                'first_name', 'last_name', 'email', 'phone', 
                'country_id', 'gender', 'linkedin_url', 
                'additional_notes', 'cv'
            ]);

        } catch (\Exception $e) {
            Log::error('Job Application Error: ' . $e->getMessage());
            $this->addError('application_error', 'There was a problem submitting your application. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.career-application-form');
    }
}