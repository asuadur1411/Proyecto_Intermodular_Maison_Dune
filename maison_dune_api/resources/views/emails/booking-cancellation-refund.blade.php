@extends('emails.layout')

@section('subtitle', 'Booking Cancelled')

@section('content')
    @php
        $confirmCode = 'MD-R' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);
        $checkInDate = \Illuminate\Support\Carbon::parse($reservation->date);
        $checkOut    = $reservation->checkout_date
            ? \Illuminate\Support\Carbon::parse($reservation->checkout_date)
            : null;
        $total       = (float) $reservation->total_price;
        $refundFee   = max(0, round($total - $refundAmount, 2));

        $methodLabels = [
            'card'     => 'Original card ending in 4242',
            'paypal'   => 'PayPal account',
            'applepay' => 'Apple Pay (original device)',
            'original' => 'Original payment method',
        ];
        $methodLabel = $methodLabels[$refundMethod] ?? 'Original payment method';
    @endphp

    <p class="md-greet" style="font-size: 16px; color: #1a1a1a; margin: 0 0 14px;">
        Dear <strong>{{ $reservation->first_name }} {{ $reservation->last_name }}</strong>,
    </p>
    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        We confirm that your reservation at <strong>Maison Dune</strong> has been cancelled.
        We are sorry to see you go and hope to welcome you on another occasion.
    </p>

    <!-- Cancelled booking summary -->
    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 22px 24px; margin: 0 0 24px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 14px;">Cancelled booking</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Confirmation</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $confirmCode }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Suite</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $reservation->room_title }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Stay</td>
                <td style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">
                    {{ $checkInDate->format('D, j M Y') }}
                    @if($checkOut) &nbsp;→&nbsp; {{ $checkOut->format('D, j M Y') }} @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Refund block -->
    <div style="background: linear-gradient(135deg, #1a1714 0%, #2c2520 100%); padding: 26px 24px; margin: 0 0 24px; text-align: center; color: #fff;">
        <p style="font-size: 11px; letter-spacing: 3px; text-transform: uppercase; color: #c9a84c; margin: 0 0 8px; font-family: Arial, sans-serif;">Refund summary</p>
        <p style="font-size: 13px; color: #d8c89a; margin: 0 0 12px; font-family: Arial, sans-serif;">{{ $refundPercentLabel }} · {{ $policyReason }}</p>
        <div style="font-family: 'Georgia', serif; font-size: 38px; font-weight: 500; letter-spacing: 1px; margin: 4px 0 8px;">€{{ number_format($refundAmount, 2) }}</div>
        <div style="width: 50px; height: 1px; background-color: #c9a84c; margin: 12px auto;"></div>
        <p style="font-size: 12px; color: #d8c89a; margin: 0; font-family: Arial, sans-serif;">
            To be refunded to:<br>
            <strong style="color: #ffffff;">{{ $methodLabel }}</strong>
        </p>
    </div>

    <!-- Breakdown -->
    <div style="border: 1px solid #e5e0d3; padding: 20px 24px; margin: 0 0 24px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 12px;">Breakdown</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 6px 0; font-size: 13px; color: #555;">Original amount paid</td>
                <td style="padding: 6px 0; font-size: 13px; color: #1a1a1a; text-align: right;">€{{ number_format($total, 2) }}</td>
            </tr>
            @if($refundFee > 0)
            <tr>
                <td style="padding: 6px 0; font-size: 13px; color: #b85a3e;">Cancellation fee</td>
                <td style="padding: 6px 0; font-size: 13px; color: #b85a3e; text-align: right;">−€{{ number_format($refundFee, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="2" style="padding: 8px 0 0; border-top: 1px solid #e5e0d3;"></td>
            </tr>
            <tr>
                <td style="padding: 10px 0 0; font-size: 13px; color: #1a1a1a; font-weight: 600; letter-spacing: 0.5px;">Refund amount</td>
                <td style="padding: 10px 0 0; font-size: 18px; color: #2c8a4a; text-align: right; font-weight: 600; font-family: 'Georgia', serif;">€{{ number_format($refundAmount, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Timing note -->
    <div style="background-color: #fdfaf3; border: 1px dashed #c9a84c; padding: 16px 20px; margin: 0 0 24px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 6px;">Processing time</p>
        <p style="font-size: 12px; color: #555; line-height: 1.7; margin: 0;">
            Refunds are typically processed within <strong>5–10 business days</strong>, depending on your bank or payment provider.
            You will see the credit appear on your statement under <em>"MAISON DUNE — REFUND {{ $confirmCode }}"</em>.
        </p>
    </div>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        If you have any questions about this refund or wish to make a new booking,
        our concierge team is here to help.
    </p>

    <div style="text-align: center; padding: 18px 0 0; border-top: 1px solid #e5e0d3;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 10px;">Contact</p>
        <p style="font-size: 13px; color: #1a1a1a; line-height: 1.7; margin: 0;">
            <a href="mailto:proyectomaison20@gmail.com" style="color: #1a1a1a; text-decoration: none;">proyectomaison20@gmail.com</a><br>
            <span style="font-size: 12px; color: #777;">Maison Dune · St. Guadix 18690, Almuñecar · Granada</span>
        </p>
    </div>
@endsection
