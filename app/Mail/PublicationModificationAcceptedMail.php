<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Publication;

class PublicationModificationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $publication;

    /**
     * Create a new message instance.
     */
    public function __construct(Publication $publication)
    {
        $this->publication = $publication;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Modification de votre publication acceptée')
                    ->view('mail.publication-modification-accepted');
    }
}