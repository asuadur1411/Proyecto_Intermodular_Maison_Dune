@extends('emails.layout')

@section('subtitle', 'Reservation Confirmed')

@section('content')
    @php
        $confirmCode = 'MD-' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);
        $qrPayload   = $confirmCode . '|' . $reservation->date . '|' . substr((string) $reservation->time, 0, 5);
        $qrUrl       = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&margin=4&data=' . urlencode($qrPayload);
    @endphp
    <p class="md-greet" style="font-size: 16px; color: #1a1a1a; margin: 0 0 20px;">Dear <strong>{{ $reservation->first_name }}</strong>,</p>
    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        Thank you for your reservation. We look forward to welcoming you at Maison Dune.
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 20px 24px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Date</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($reservation->date)) }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Time</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->time }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Guests</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->guests }}</td>
            </tr>
            @if($reservation->section)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Section</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ ucfirst($reservation->section) }}</td>
            </tr>
            @endif
            @if($reservation->table_number)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Table</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">Table {{ $reservation->table_number }}</td>
            </tr>
            @endif
            @if($reservation->room_number)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Room</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">Room {{ $reservation->room_number }}</td>
            </tr>
            @endif
            @if($reservation->notes)
            <tr>
                <td class="md-detail-label" style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Notes</td>
                <td class="md-detail-value" style="padding: 10px 0; font-size: 14px; color: #1a1a1a; line-height: 1.6;">{{ $reservation->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- QR code + confirmation code -->
    <table class="md-stack" style="width: 100%; border-collapse: collapse; margin: 28px 0 8px;">
        <tr>
            <td class="md-stack-cell md-qr-cell" style="width: 220px; vertical-align: middle; padding-right: 20px; text-align: center;">
                <div style="background-color: #ffffff; border: 1px solid #e5e0d3; padding: 10px; display: inline-block; border-radius: 6px;">
                    <img src="{{ $qrUrl }}" alt="Reservation QR code" width="180" height="180" style="display: block; width: 180px; height: 180px;">
                </div>
            </td>
            <td class="md-stack-cell" style="vertical-align: middle;">
                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin-bottom: 6px;">
                    Confirmation code
                </div>
                <div class="md-confirm-code" style="font-size: 26px; color: #1a1a1a; font-weight: 600; letter-spacing: 2px; font-family: 'Georgia', serif; margin-bottom: 14px;">
                    {{ $confirmCode }}
                </div>
                <p class="md-body" style="font-size: 13px; color: #555; line-height: 1.6; margin: 0;">
                    Show this QR code to our host upon arrival for instant check-in.
                </p>
            </td>
        </tr>
    </table>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 24px 0 0;">
        Should you need to modify or cancel your reservation, please visit your account on our website.
    </p>
@endsection
