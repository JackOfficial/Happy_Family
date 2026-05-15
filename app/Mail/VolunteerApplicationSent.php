<?php

namespace App\Mail;

use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerApplicationSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The volunteer instance.
     *
     * @var \App\Models\Volunteer
     */
    public $volunteer;

    /**
     * Create a new message instance.
     */
    public function __construct(Volunteer $volunteer)
    {
        // We load the address and country relationships to ensure they are available in the view
        $this->volunteer = $volunteer->load(['address', 'country']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->volunteer->email, $this->volunteer->name),
            subject: 'New Volunteer Application: ' . $this->volunteer->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Create this blade at resources/views/emails/volunteer_application.blade.php
            view: 'emails.volunteer_application',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}