<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminCancellationNotice extends Mailable
{
    use Queueable, SerializesModels;

    public string $type;

    public function __construct(public Reservation $reservation)
    {
        if (!empty($reservation->room_slug)) {
            $this->type = 'room';
        } elseif (!empty($reservation->event_slug)) {
            $this->type = 'event';
        } else {
            $this->type = 'restaurant';
        }
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'room'       => 'Room Booking Cancelled — Maison Dune',
            'event'      => 'Event Registration Cancelled — Maison Dune',
            'restaurant' => 'Reservation Cancelled — Maison Dune',
        ];

        return new Envelope(
            subject: $subjects[$this->type],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-cancellation-notice',
            with: [
                'type'        => $this->type,
                'reservation' => $this->reservation,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
