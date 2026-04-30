<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function envelope(): Envelope
    {
        $title = $this->reservation->event_title ?: 'Maison Dune Event';
        return new Envelope(
            subject: 'Event Registration Confirmed — ' . $title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-registration-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
