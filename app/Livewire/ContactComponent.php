<?php

namespace App\Livewire;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ContactComponent extends Component
{
    // Added $phone and $subject to match your new migration
    public $name, $email, $phone, $subject, $message;

    public function contact()
    {
        // 1. Validate all fields including the new migration additions
        $validatedData = $this->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            // 2. Create the contact record in the database
            $contact = Contact::create($validatedData);

            if ($contact) {
                // 3. Send the notification email to your Gmail
                $toMail = "musengimanajacques@gmail.com";
                
                // We pass the $contact object directly for a cleaner Mailable
                Mail::to($toMail)->send(new ContactMail($contact));

                // 4. Reset form fields
                $this->reset();

                // 5. Success Feedback
                session()->flash('contactSuccess', 'Thank you for reaching out! Your message was sent successfully.');
            }
        } catch (\Exception $e) {
            // Log the error for debugging on server349
            Log::error('Contact Form Error: ' . $e->getMessage());
            
            session()->flash('contactFail', 'Oops! Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.contact-component');
    }
}