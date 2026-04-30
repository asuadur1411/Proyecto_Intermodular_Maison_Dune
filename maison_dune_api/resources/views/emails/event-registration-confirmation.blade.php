@extends('emails.layout')

@section('subtitle', 'Event Registration Confirmed')

@section('content')
    @php
        $confirmCode = 'MD-' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);
        $qrPayload   = $confirmCode . '|' . $reservation->date . '|' . substr((string) $reservation->time, 0, 5);
        $qrUrl       = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=4&data=' . urlencode($qrPayload);
        $eventTitle  = $reservation->event_title ?: 'Maison Dune Event';
        $location    = $reservation->room_number ?: 'Maison Dune';
    @endphp

    <p class="md-greet" style="font-size: 16px; color: #1a1a1a; margin: 0 0 12px;">
        Dear <strong>{{ $reservation->first_name }}</strong>,
    </p>
    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        Your spot is secured. We are delighted to welcome you to our upcoming event at Maison Dune.
    </p>

    <!-- Event headline card -->
    <div style="background: linear-gradient(135deg, #1a1714 0%, #2a2620 100%); padding: 26px 24px; margin: 0 0 24px; text-align: center;">
        <p style="font-size: 10px; text-transform: uppercase; letter-spacing: 3px; color: #c9a84c; margin: 0 0 8px; font-family: Arial, sans-serif;">★ You're going to</p>
        <p style="font-size: 24px; color: #ffffff; margin: 0; font-family: 'Georgia', serif; line-height: 1.2;">
            {{ $eventTitle }}
        </p>
    </div>

    <!-- Details -->
    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 20px 24px; margin: 0 0 24px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Date</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($reservation->date)) }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Start time</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ substr((string) $reservation->time, 0, 5) }}h</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Location</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $location }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Guests</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->guests }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Name</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
            </tr>
            @if($reservation->notes)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 110px; vertical-align: top; font-family: Arial, sans-serif;">Notes</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a; line-height: 1.6;">{{ $reservation->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- QR + confirmation code -->
    <table class="md-stack" style="width: 100%; border-collapse: collapse; margin: 28px 0 8px;">
        <tr>
            <td class="md-stack-cell md-qr-cell" style="width: 220px; vertical-align: middle; padding-right: 20px; text-align: center;">
                <div style="background-color: #ffffff; border: 1px solid #e5e0d3; padding: 10px; display: inline-block; border-radius: 6px;">
                    <img src="{{ $qrUrl }}" alt="Event ticket QR code" width="180" height="180" style="display: block; width: 180px; height: 180px;">
                </div>
            </td>
            <td class="md-stack-cell" style="vertical-align: middle;">
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin-bottom: 6px;">
                    Your ticket code
                </div>
                <div class="md-confirm-code" style="font-size: 26px; color: #1a1a1a; font-weight: 600; letter-spacing: 2px; font-family: 'Georgia', serif; margin-bottom: 14px;">
                    {{ $confirmCode }}
                </div>
                <p class="md-body" style="font-size: 13px; color: #555; line-height: 1.6; margin: 0;">
                    Present this QR code at the entrance for instant check-in.
                </p>
            </td>
        </tr>
    </table>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 24px 0 6px;">
        You can review or cancel your registration any time from your dashboard.
    </p>
    <p class="md-body" style="font-size: 12px; color: #888; line-height: 1.6; margin: 0;">
        Please arrive 10 minutes before the start time. Dress code as detailed on the event page.
    </p>
@endsection
