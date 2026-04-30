@extends('emails.layout')

@section('subtitle', 'Message Received')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin: 0 0 20px;">Dear <strong>{{ $contact->name }}</strong>,</p>
    <p style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        Thank you for reaching out to Maison Dune. We have received your message and our team will get back to you as soon as possible.
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 20px 24px; margin: 24px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Subject</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a;">{{ $contact->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 100px; vertical-align: top; font-family: Arial, sans-serif;">Message</td>
                <td style="padding: 10px 0; font-size: 14px; color: #1a1a1a; line-height: 1.6;">{{ $contact->message }}</td>
            </tr>
        </table>
    </div>

    <p style="font-size: 14px; color: #555; line-height: 1.8; margin: 24px 0 0;">
        We appreciate your interest and look forward to assisting you.
    </p>
@endsection
