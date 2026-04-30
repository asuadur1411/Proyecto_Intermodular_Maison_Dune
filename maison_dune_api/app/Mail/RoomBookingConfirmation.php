<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RoomBookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function envelope(): Envelope
    {
        $code = 'MD-R' . str_pad((string) $this->reservation->id, 5, '0', STR_PAD_LEFT);

        return new Envelope(
            subject: 'Booking Confirmed · ' . $code . ' — Maison Dune',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.room-booking-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
