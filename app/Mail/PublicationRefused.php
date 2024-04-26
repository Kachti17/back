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

class PublicationRefused extends Mailable
{
    use Queueable, SerializesModels;
    use Queueable, SerializesModels;

    public $publication;

    /**
     * Create a new message instance.
     */
    public function __construct(Publication $publication)
    {
        $this->publication = $publication;
    }

    public function build()
    {
        return $this->subject('Refus de votre demande de publication')
            ->view('mail.publication-refused');
    }
}