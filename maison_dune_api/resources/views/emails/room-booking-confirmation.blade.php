@extends('emails.layout')

@section('subtitle', 'Your Suite Awaits')

@section('content')
    @php
        $confirmCode = 'MD-R' . str_pad((string) $reservation->id, 5, '0', STR_PAD_LEFT);

        $checkInDate  = \Illuminate\Support\Carbon::parse($reservation->date);
        $checkOutDate = \Illuminate\Support\Carbon::parse($reservation->checkout_date);
        $nights       = max(1, $checkInDate->diffInDays($checkOutDate));

        $total        = (float) $reservation->total_price;
        $ratePerNight = $nights > 0 ? round($total / $nights, 2) : $total;

        $qrPayload    = $confirmCode . '|' . $checkInDate->format('Y-m-d') . '|' . $checkOutDate->format('Y-m-d');
        $qrUrl        = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=4&data=' . urlencode($qrPayload);

        $roomTitle    = $reservation->room_title ?: 'Maison Dune Suite';
        $guests       = (int) $reservation->guests;
    @endphp

    <p class="md-greet" style="font-size: 16px; color: #1a1a1a; margin: 0 0 14px;">
        Dear <strong>{{ $reservation->first_name }} {{ $reservation->last_name }}</strong>,
    </p>
    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 8px;">
        It is our great pleasure to confirm your reservation at <strong>Maison Dune</strong>.
        Every detail of your stay has been arranged with care, and our team is already preparing
        to welcome you the way only Maison Dune knows how.
    </p>
    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 26px;">
        A summary of your booking is enclosed below. Please keep this email for your records.
    </p>

    <!-- Hero / Suite -->
    <div style="background: linear-gradient(135deg, #1a1714 0%, #2c2520 100%); padding: 28px 26px; margin: 0 0 24px; text-align: center;">
        <p style="font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: #c9a84c; margin: 0 0 10px; font-family: Arial, sans-serif;">Reserved for {{ $reservation->first_name }}</p>
        <h2 style="font-family: 'Georgia', serif; font-size: 26px; font-weight: 400; color: #ffffff; margin: 0 0 6px; letter-spacing: 1px;">{{ $roomTitle }}</h2>
        <div style="width: 50px; height: 1px; background-color: #c9a84c; margin: 12px auto;"></div>
        <p style="font-size: 13px; color: #d8c89a; margin: 0; font-family: Arial, sans-serif; letter-spacing: 0.5px;">
            {{ $checkInDate->format('D, j M Y') }} &nbsp;→&nbsp; {{ $checkOutDate->format('D, j M Y') }}
            &nbsp;·&nbsp; {{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}
        </p>
    </div>

    <!-- Stay details -->
    <div style="background-color: #f9f7f3; border-left: 3px solid #c9a84c; padding: 22px 24px; margin: 0 0 24px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 14px;">Stay details</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Check-in</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">
                    <strong>{{ $checkInDate->format('l, F j, Y') }}</strong><br>
                    <span style="font-size: 12px; color: #777;">From 15:00</span>
                </td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Check-out</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">
                    <strong>{{ $checkOutDate->format('l, F j, Y') }}</strong><br>
                    <span style="font-size: 12px; color: #777;">By 12:00</span>
                </td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Nights</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $nights }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Guests</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">{{ $guests }} {{ $guests === 1 ? 'guest' : 'guests' }}</td>
            </tr>
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Booked under</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a;">
                    {{ $reservation->first_name }} {{ $reservation->last_name }}<br>
                    <span style="font-size: 12px; color: #777;">{{ $reservation->email }}</span>
                    @if($reservation->phone)
                        <br><span style="font-size: 12px; color: #777;">+34 {{ $reservation->phone }}</span>
                    @endif
                </td>
            </tr>
            @if($reservation->notes)
            <tr>
                <td class="md-detail-label" style="padding: 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #c9a84c; width: 140px; vertical-align: top; font-family: Arial, sans-serif;">Special requests</td>
                <td class="md-detail-value" style="padding: 8px 0; font-size: 14px; color: #1a1a1a; line-height: 1.6;">{{ $reservation->notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Pricing -->
    <div style="border: 1px solid #e5e0d3; padding: 22px 24px; margin: 0 0 24px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 14px;">Payment receipt</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 6px 0; font-size: 13px; color: #555;">{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }} × €{{ number_format($ratePerNight, 2) }}</td>
                <td style="padding: 6px 0; font-size: 13px; color: #1a1a1a; text-align: right;">€{{ number_format($total, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-size: 12px; color: #777;">Taxes &amp; service</td>
                <td style="padding: 6px 0; font-size: 12px; color: #777; text-align: right;">Included</td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 8px 0 0; border-top: 1px solid #e5e0d3;"></td>
            </tr>
            <tr>
                <td style="padding: 10px 0 0; font-size: 13px; color: #1a1a1a; font-weight: 600; letter-spacing: 0.5px;">Total charged</td>
                <td style="padding: 10px 0 0; font-size: 18px; color: #1a1a1a; text-align: right; font-weight: 600; font-family: 'Georgia', serif;">€{{ number_format($total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 6px 0 0; font-size: 11px; color: #888; font-family: Arial, sans-serif;">
                    Payment received and confirmed. No further action required.
                </td>
            </tr>
        </table>
    </div>

    <!-- QR + confirmation code -->
    <table class="md-stack" style="width: 100%; border-collapse: collapse; margin: 8px 0 28px;">
        <tr>
            <td class="md-stack-cell md-qr-cell" style="width: 240px; vertical-align: middle; padding-right: 22px; text-align: center;">
                <div style="background-color: #ffffff; border: 1px solid #e5e0d3; padding: 10px; display: inline-block; border-radius: 6px;">
                    <img src="{{ $qrUrl }}" alt="Booking QR code" width="200" height="200" style="display: block; width: 200px; height: 200px;">
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
                    Present this QR code at reception for an expedited check-in.
                    You may also find it anytime in <em>My Reservations</em>.
                </p>
            </td>
        </tr>
    </table>

    <!-- Plan your stay -->
    <div style="margin: 0 0 22px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 14px;">Plan your stay</p>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; padding: 0 12px 14px 0; vertical-align: top;">
                    <p style="font-size: 13px; color: #1a1a1a; font-weight: 600; margin: 0 0 4px;">Arrival &amp; check-in</p>
                    <p style="font-size: 12px; color: #666; line-height: 1.6; margin: 0;">Reception is open 24/7. Complimentary valet parking available on arrival.</p>
                </td>
                <td style="width: 50%; padding: 0 0 14px 12px; vertical-align: top;">
                    <p style="font-size: 13px; color: #1a1a1a; font-weight: 600; margin: 0 0 4px;">Breakfast included</p>
                    <p style="font-size: 12px; color: #666; line-height: 1.6; margin: 0;">À la carte breakfast served at our restaurant from 7:30 to 11:00 AM daily.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%; padding: 0 12px 14px 0; vertical-align: top;">
                    <p style="font-size: 13px; color: #1a1a1a; font-weight: 600; margin: 0 0 4px;">In-suite amenities</p>
                    <p style="font-size: 12px; color: #666; line-height: 1.6; margin: 0;">High-speed Wi-Fi, premium toiletries, in-room espresso and 24h room service.</p>
                </td>
                <td style="width: 50%; padding: 0 0 14px 12px; vertical-align: top;">
                    <p style="font-size: 13px; color: #1a1a1a; font-weight: 600; margin: 0 0 4px;">Concierge</p>
                    <p style="font-size: 12px; color: #666; line-height: 1.6; margin: 0;">Spa bookings, restaurant reservations and excursions can be arranged before or upon arrival.</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Cancellation policy -->
    <div style="background-color: #fdfaf3; border: 1px dashed #c9a84c; padding: 16px 20px; margin: 0 0 26px;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 6px;">Cancellation policy</p>
        <p style="font-size: 12px; color: #555; line-height: 1.7; margin: 0;">
            Free cancellation up to <strong>48 hours</strong> before your check-in date.
            Cancellations within 48 hours of arrival, no-shows and early departures will be charged the full amount of the stay.
        </p>
    </div>

    <p class="md-body" style="font-size: 14px; color: #555; line-height: 1.8; margin: 0 0 24px;">
        Should you need to modify your booking, request additional services or share special preferences for your stay,
        please reply to this email or call our concierge directly. We are at your entire disposal.
    </p>

    <!-- Contact -->
    <div style="text-align: center; padding: 18px 0 0; border-top: 1px solid #e5e0d3;">
        <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #c9a84c; font-family: Arial, sans-serif; margin: 0 0 10px;">Contact</p>
        <p style="font-size: 13px; color: #1a1a1a; line-height: 1.7; margin: 0;">
            <a href="mailto:proyectomaison20@gmail.com" style="color: #1a1a1a; text-decoration: none;">proyectomaison20@gmail.com</a><br>
            <span style="font-size: 12px; color: #777;">Maison Dune · St. Guadix 18690, Almuñecar · Granada</span>
        </p>
    </div>
@endsection
