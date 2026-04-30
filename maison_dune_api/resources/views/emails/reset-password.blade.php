@extends('emails.layout')

@section('subtitle', 'Password Reset')

@section('content')
    <p style="font-size: 16px; color: #1a1a1a; margin: 0 0 20px;">Dear <strong>{{ $name }}</strong>,</p>
    <p style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 8px;">
        We received a request to reset the password for your Maison Dune account. Click the button below to set a new password.
    </p>

    <div style="text-align: center; margin: 36px 0;">
        <a href="{{ $url }}" style="display: inline-block; background-color: #1a1714; color: #c9a84c; font-family: Arial, sans-serif; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; padding: 16px 40px; border: 1px solid #c9a84c;">Reset Password</a>
    </div>

    <p style="font-size: 13px; color: #888; line-height: 1.7; margin: 0 0 16px;">
        This link will expire in 60 minutes. If you did not request a password reset, no action is required.
    </p>

    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 14px 18px; margin: 20px 0 0;">
        <p style="font-size: 12px; color: #888; margin: 0; line-height: 1.6;">
            If the button above does not work, copy and paste the following link into your browser:<br>
            <span style="color: #c9a84c; word-break: break-all;">{{ $url }}</span>
        </p>
    </div>
@endsection
