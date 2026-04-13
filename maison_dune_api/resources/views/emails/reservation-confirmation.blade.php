@extends('emails.layout')

@section('subtitle', 'Reservation Confirmed')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin-bottom: 24px;">Dear {{ $reservation->first_name }},</p>
    <p style="font-size: 14px; color: #555; line-height: 1.7;">
        Thank you for your reservation. We look forward to welcoming you.
    </p>

    <div style="background-color: #f7f4ef; border: 1px solid #d4c5a0; border-radius: 4px; padding: 20px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Date</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($reservation->date)) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Time</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->time }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Guests</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->guests }}</td>
            </tr>
            @if($reservation->section)
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Section</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ ucfirst($reservation->section) }}</td>
            </tr>
            @endif
            @if($reservation->table_number)
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Table</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">Table {{ $reservation->table_number }}</td>
            </tr>
            @endif
            @if($reservation->room_number)
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Room</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">Room {{ $reservation->room_number }}</td>
            </tr>
            @endif
            @if($reservation->notes)
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Notes</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->notes }}</td>
            </tr>
            @endif
        </table>
    </div>
@endsection
