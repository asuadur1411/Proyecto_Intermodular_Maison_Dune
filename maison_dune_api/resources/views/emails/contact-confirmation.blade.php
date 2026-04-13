@extends('emails.layout')

@section('subtitle', 'Message Received')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin-bottom: 24px;">Dear {{ $contact->name }},</p>
    <p style="font-size: 14px; color: #555; line-height: 1.7;">
        Thank you for reaching out to Maison Dune. We have received your message and our team will get back to you as soon as possible.
    </p>

    <div style="background-color: #f7f4ef; border: 1px solid #d4c5a0; border-radius: 4px; padding: 20px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Subject</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $contact->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #915c00; width: 120px; vertical-align: top;">Message</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $contact->message }}</td>
            </tr>
        </table>
    </div>

    <p style="font-size: 14px; color: #555; line-height: 1.7;">
        We appreciate your interest and look forward to assisting you.
    </p>
@endsection
