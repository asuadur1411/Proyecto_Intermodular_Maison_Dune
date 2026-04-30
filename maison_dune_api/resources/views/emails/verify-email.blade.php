@extends('emails.layout')

@section('subtitle', 'Email Verification')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin: 0 0 20px;">Dear <strong>{{ $name }}</strong>,</p>
    <p style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 8px;">
        Thank you for creating an account at Maison Dune. To complete your registration and access all our exclusive services, please verify your email address.
    </p>

    <div style="text-align: center; margin: 36px 0;">
        <a href="{{ $url }}" style="display: inline-block; background-color: #1a1714; color: #c9a84c; font-family: Arial, sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; padding: 16px 40px; border: 1px solid #c9a84c;">Verify Email Address</a>
    </div>

    <p style="font-size: 13px; color: #888; line-height: 1.7; margin: 0 0 16px;">
        If you did not create an account, no further action is required.
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 14px 18px; margin: 20px 0 0;">
        <p style="font-size: 12px; color: #888; margin: 0; line-height: 1.6;">
            If the button above does not work, copy and paste the following link into your browser:<br>
            <span style="color: #c9a84c; word-break: break-all;">{{ $url }}</span>
        </p>
    </div>
@endsection
