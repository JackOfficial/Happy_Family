<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class CareerApplicationForm extends Component
{
    use WithFileUploads;

    // Data passed from parent
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

    public function mount($job, $countries)
    {
        $this->job = $job;
        $this->countries = $countries;
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:25',
            'country_id' => 'required|exists:countries,id',
            'gender'     => 'nullable|string',
            'linkedin_url' => 'nullable|url',
            'additional_notes' => 'nullable|string|max:2000',
            'cv'         => 'required|mimes:pdf,doc,docx|max:10240', // 10MB limit
        ];
    }

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

                // 2. Handle Polymorphic Attachment
                if ($this->cv) {
                    $path = $this->cv->store('applications/cvs', 'private');

                    $application->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $this->cv->getClientOriginalName(),
                        'file_type' => 'cv',
                        // Add other fields required by your Attachment model migration
                    ]);
                }
            });

            session()->flash('message', 'Application for ' . $this->job->title . ' submitted successfully!');
            
            // Reset form fields
            $this->reset([
                'first_name', 'last_name', 'email', 'phone', 
                'country_id', 'gender', 'linkedin_url', 
                'additional_notes', 'cv'
            ]);

        } catch (\Exception $e) {
            // Log the error if needed: Log::error($e->getMessage());
            $this->addError('application_error', 'Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.career-application-form');
    }
}