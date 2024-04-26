<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Publication;


class PublicationApprovedMail extends Mailable
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
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de publication approuvée')
            ->view('mail.publication-approved');
    }
}