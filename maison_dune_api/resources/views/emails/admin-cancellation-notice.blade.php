@extends('emails.layout')

@section('subtitle', 'Reservation Cancelled')

@section('content')
    @php
        $confirmCode = 'MD-' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);

        $headlines = [
            'restaurant' => 'Your restaurant reservation has been cancelled',
            'event'      => 'Your event registration has been cancelled',
            'room'       => 'Your room booking has been cancelled',
        ];

        $intros = [
            'restaurant' => 'We regret to inform you that your dining reservation at Maison Dune has been cancelled by our administration.',
            'event'      => 'We regret to inform you that your registration for the following event at Maison Dune has been cancelled by our administration.',
            'room'       => 'We regret to inform you that your room booking at Maison Dune has been cancelled by our administration.',
        ];

        $hasRefund = !empty($reservation->room_slug) && !is_null($reservation->total_price);
    @endphp

    <p class="md-greet" style="font-size: 16px; color: #1a1a1a; margin: 0 0 18px;">
        Dear <strong>{{ $reservation->first_name }} {{ $reservation->last_name }}</strong>,
    </p>

    <h2 style="font-family: 'Georgia', serif; font-size: 20px; color: #1a1a1a; margin: 0 0 14px; font-weight: 400;">
        {{ $headlines[$type] }}
    </h2>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 22px;">
        {{ $intros[$type] }}
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 20px 24px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Reference</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $confirmCode }}</td>
            </tr>

            @if($type === 'event' && $reservation->event_title)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Event</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->event_title }}</td>
            </tr>
            @endif

            @if($type === 'room' && ($reservation->room_title ?? null))
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Room</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->room_title }}</td>
            </tr>
            @endif

            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">
                    {{ $type === 'room' ? 'Check-in' : 'Date' }}
                </td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($reservation->date)) }}</td>
            </tr>

            @if($type === 'room' && $reservation->checkout_date)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Check-out</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($reservation->checkout_date)) }}</td>
            </tr>
            @endif

            @if($type !== 'room')
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Time</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ substr((string) $reservation->time, 0, 5) }}</td>
            </tr>
            @endif

            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Guests</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->guests }}</td>
            </tr>

            @if($hasRefund)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 130px; vertical-align: top; font-family: Arial, sans-serif;">Amount paid</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">€ {{ number_format((float) $reservation->total_price, 2, ',', '.') }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($hasRefund)
        <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 18px;">
            Since this cancellation has been initiated by our team, the full amount paid will be refunded to your original method of payment within 5–10 business days. No further action is required on your part.
        </p>
    @endif

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 18px;">
        We sincerely apologise for any inconvenience this may cause. If you would like further information regarding this cancellation, or wish to arrange an alternative reservation, please do not hesitate to contact our reception team:
    </p>

    <div style="background-color: #1a1714; padding: 20px 24px; margin: 18px 0 24px; text-align: center;">
        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin-bottom: 8px;">
            Maison Dune Reception
        </div>
        <a href="mailto:proyectomaison20@gmail.com" style="font-size: 16px; color: #f5e9c8; text-decoration: none; font-family: 'Georgia', serif; letter-spacing: 1px;">
            proyectomaison20@gmail.com
        </a>
    </div>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 24px 0 0;">
        Please reference your booking code <strong>{{ $confirmCode }}</strong> in any correspondence so that our team can attend to your enquiry promptly.
    </p>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 18px 0 0;">
        Thank you for your understanding.
    </p>

    <p class="md-body" style="font-size: 14px; color: #1a1a1a; line-height: 1.8; margin: 22px 0 0; font-style: italic;">
        The Maison Dune Team
    </p>
@endsection
