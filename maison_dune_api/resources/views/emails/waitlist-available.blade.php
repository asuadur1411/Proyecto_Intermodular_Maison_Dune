@extends('emails.layout')

@section('subtitle', 'Table Available')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin: 0 0 20px;">Dear <strong>{{ $waitlist->first_name }}</strong>,</p>
    <p style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        Great news! A table matching your waitlist request is now available at Maison Dune. Reserve it before someone else does.
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 20px 24px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Date</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ date('l, F j, Y', strtotime($waitlist->date)) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Time</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $waitlist->time }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Guests</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $waitlist->guests }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Section</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ ucfirst($waitlist->section) }}</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin: 36px 0;">
        <a href="{{ config('app.frontend_url', config('app.url')) }}/table" style="display: inline-block; background-color: #1a1714; color: #c9a84c; font-family: Arial, sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; padding: 16px 40px; border: 1px solid #c9a84c;">Book Now</a>
    </div>

    <p style="font-size: 13px; color: #888; line-height: 1.7; margin: 0;">
        Tables are available on a first-come, first-served basis. We recommend booking as soon as possible to secure your spot.
    </p>
@endsection
