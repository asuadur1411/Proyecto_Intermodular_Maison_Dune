<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChatbotController extends Controller
{
    private array $knowledge = [
        'hotel' => [
            'name' => 'Maison Dune',
            'location' => 'Maro-Cerro Gordo Cliffs, Costa Tropical, Almuñécar, Granada, Spain',
            'description' => 'An exclusive boutique hotel and luxury restaurant on the Costa Tropical of Granada, where Arab heritage and contemporary comfort converge in sublime harmony.',
        ],
        'restaurant' => [
            'name' => 'Ziryab',
            'cuisine' => 'Signature Arabic-Mediterranean cuisine featuring a Tandoor oven and oak charcoal grill.',
            'hours' => '9:00 AM to 12:00 AM (midnight), every day.',
            'sections' => [
                'interior' => 'Intimate and elegant indoor dining room.',
                'terrace' => 'Terrace with sea views and stunning sunsets.',
                'private' => 'Private room for exclusive events and celebrations.',
            ],
        ],
        'rooms' => [
            'classic' => [
                'name' => 'Classic Rooms',
                'size' => '28–35 m²',
                'features' => 'Premium king bed, Andalusian patio views, marble bathroom with rain shower.',
            ],
            'superior' => [
                'name' => 'Superior Rooms',
                'size' => '35–45 m²',
                'features' => 'Extended space, sitting area, privileged views.',
            ],
            'deluxe' => [
                'name' => 'Deluxe Rooms',
                'size' => '45–55 m²',
                'features' => 'Private terrace, freestanding bathtub, luxury amenities.',
            ],
            'suite' => [
                'name' => 'Suites',
                'features' => 'Separate living area, terrace with panoramic views, personalised service.',
            ],
            'exceptional' => [
                'name' => 'Exceptional Suites',
                'features' => 'Museum-quality antiques, dedicated 24/7 butler service, ultra-exclusive experience.',
            ],
        ],
        'services' => [
            'room_service' => 'In-room dining available 24 hours a day, 7 days a week.',
            'events' => 'We host weddings, private celebrations, corporate dinners and exclusive events in our private rooms.',
            'wine' => 'We offer a curated selection of fine wines from the finest appellations.',
        ],
    ];

    public function handle(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = mb_strtolower(trim($request->input('message')));
        $user = $request->user();

        $response = $this->detectAndRespond($message, $user);

        return response()->json([
            'success' => true,
            'reply' => $response['reply'],
            'type' => $response['type'] ?? 'text',
            'data' => $response['data'] ?? null,
        ]);
    }

    private function detectAndRespond(string $message, $user): array
    {
        if ($this->matchesIntent($message, ['availability', 'available', 'free table', 'table for', 'tables available', 'any table', 'book a table for', 'is there a table'])) {
            return $this->handleAvailability($message);
        }

        if ($this->matchesIntent($message, ['my reservation', 'my reservations', 'my booking', 'my bookings', 'view reservation', 'see reservation', 'how many reservation'])) {
            return $this->handleUserReservations($user);
        }

        if ($this->matchesIntent($message, ['how to book', 'how to reserve', 'how do i book', 'how do i reserve', 'make a reservation', 'want to book', 'want to reserve', 'i\'d like to book'])) {
            return [
                'reply' => "To reserve a table at Ziryab:\n\n1. Sign up or log in to your account.\n2. Verify your email (you'll receive a link).\n3. Go to the **Table** section in the menu.\n4. Choose your date, time, number of guests and section.\n5. Select your preferred table and confirm.\n\nWould you like to go to the booking page?",
                'type' => 'action',
                'data' => ['link' => '/table/', 'label' => 'Book a table'],
            ];
        }

        if ($this->matchesIntent($message, ['cancel reservation', 'cancel booking', 'cancel my', 'how to cancel', 'delete reservation', 'remove booking'])) {
            return [
                'reply' => "To cancel a reservation:\n\n1. Go to **My Reservations** in your profile.\n2. Find the booking you wish to cancel.\n3. Click the cancel button.\n4. Confirm with your password.\n\nShall I take you there?",
                'type' => 'action',
                'data' => ['link' => '/my-reservations/', 'label' => 'My Reservations'],
            ];
        }

        if ($this->matchesIntent($message, ['restaurant', 'ziryab', 'cuisine', 'food', 'menu', 'dining', 'gastronomy', 'dish', 'dishes', 'eat', 'dinner', 'lunch', 'breakfast', 'vegetarian', 'vegan'])) {
            $r = $this->knowledge['restaurant'];
            $reply = "🍽️ **{$r['name']} Restaurant**\n\n{$r['cuisine']}\n\n**Hours:** {$r['hours']}\n\n**Dining Sections:**\n• Interior: {$r['sections']['interior']}\n• Terrace: {$r['sections']['terrace']}\n• Private: {$r['sections']['private']}";

            if ($this->matchesIntent($message, ['vegetarian', 'vegan', 'gluten', 'allergy', 'dietary', 'intolerance', 'celiac'])) {
                $reply .= "\n\nOur chef can adapt dishes to specific dietary requirements. Please mention it in the notes field when making your reservation.";
            }

            return ['reply' => $reply, 'type' => 'action', 'data' => ['link' => '/restaurant/', 'label' => 'View restaurant']];
        }

        if ($this->matchesIntent($message, ['room', 'rooms', 'suite', 'suites', 'accommodation', 'stay', 'sleep', 'lodging', 'exceptional', 'classic room', 'deluxe', 'superior'])) {
            return $this->handleRoomInfo($message);
        }

        if ($this->matchesIntent($message, ['hours', 'open', 'close', 'schedule', 'when do you open', 'opening time', 'closing time', 'what time'])) {
            return [
                'reply' => "**Maison Dune Hours:**\n\n🍽️ **Ziryab Restaurant:** 9:00 AM – 12:00 AM, every day.\n🛎️ **Room Service:** Available 24/7.\n🏨 **Front Desk:** Open 24 hours.",
            ];
        }

        if ($this->matchesIntent($message, ['where', 'location', 'address', 'directions', 'how to get', 'find you', 'map', 'located'])) {
            return [
                'reply' => "📍 **Location:**\n\n{$this->knowledge['hotel']['location']}\n\nPerched on the Maro-Cerro Gordo cliffs with direct access to the most exclusive beaches of the Costa Tropical.",
            ];
        }

        if ($this->matchesIntent($message, ['room service', 'in-room dining', 'order food', 'food to room', 'deliver to room'])) {
            return [
                'reply' => "🛎️ **Room Service**\n\n{$this->knowledge['services']['room_service']}\n\nYou can order any dish from the Ziryab restaurant menu delivered directly to your room.",
                'type' => 'action',
                'data' => ['link' => '/room-service/', 'label' => 'View Room Service'],
            ];
        }

        if ($this->matchesIntent($message, ['event', 'events', 'wedding', 'celebration', 'party', 'birthday', 'corporate', 'private dining', 'private room'])) {
            return [
                'reply' => "🎉 **Private Events**\n\n{$this->knowledge['services']['events']}\n\nWe offer customisable spaces to make your event truly unforgettable.",
                'type' => 'action',
                'data' => ['link' => '/events/', 'label' => 'View events'],
            ];
        }

        if ($this->matchesIntent($message, ['wine', 'wines', 'cellar', 'wine list', 'red wine', 'white wine', 'rosé'])) {
            return [
                'reply' => "🍷 **Wine Collection**\n\n{$this->knowledge['services']['wine']}\n\nYou can browse our full wine list in the restaurant section.",
                'type' => 'action',
                'data' => ['link' => '/restaurant/', 'label' => 'View wine list'],
            ];
        }

        if ($this->matchesIntent($message, ['contact', 'phone', 'email', 'reach', 'write', 'call', 'get in touch', 'support'])) {
            return [
                'reply' => "📧 **Contact Us**\n\nYou can reach us through the contact form on our website or directly via email.\n\nOur team will respond as soon as possible.",
                'type' => 'action',
                'data' => ['link' => '/contact/', 'label' => 'Go to contact'],
            ];
        }

        if ($this->matchesIntent($message, ['sign up', 'register', 'account', 'login', 'log in', 'sign in', 'password', 'forgot password', 'verify email', 'verification'])) {
            return $this->handleAccountInfo($message);
        }

        if ($this->matchesIntent($message, ['price', 'prices', 'cost', 'how much', 'rate', 'rates', 'tariff', 'fee'])) {
            return [
                'reply' => "For detailed pricing on rooms and services, we recommend contacting our reservations team directly or visiting the contact section.",
                'type' => 'action',
                'data' => ['link' => '/contact/', 'label' => 'Contact us'],
            ];
        }

        if ($this->matchesIntent($message, ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'greetings', 'howdy', 'what\'s up'])) {
            $greeting = $this->getTimeGreeting();
            $name = $user ? ", {$user->name}" : '';
            return [
                'reply' => "{$greeting}{$name}! I'm the Maison Dune virtual concierge. How can I help you?\n\nI can assist you with:\n• 🍽️ Restaurant & menu\n• 🏨 Rooms & suites\n• 📅 Table availability\n• 📋 Your reservations\n• 🎉 Private events\n• 📍 Location & hours",
            ];
        }

        if ($this->matchesIntent($message, ['thanks', 'thank you', 'cheers', 'great', 'perfect', 'awesome', 'wonderful', 'appreciated'])) {
            return [
                'reply' => "You're welcome! If you have any other questions, don't hesitate to ask. Enjoy the Maison Dune experience. ✨",
            ];
        }

        if ($this->matchesIntent($message, ['goodbye', 'bye', 'see you', 'farewell', 'take care', 'later'])) {
            return [
                'reply' => "Goodbye! It was a pleasure assisting you. We look forward to welcoming you at Maison Dune. 🌿",
            ];
        }

        return [
            'reply' => "I'm sorry, I didn't quite understand that. I can help you with:\n\n• **Table availability** – \"Is there a table for 4 on Saturday?\"\n• **Restaurant** – Menu, hours, dining sections\n• **Rooms** – Types, sizes, amenities\n• **Your reservations** – Status and cancellations\n• **Room Service** – Available 24/7\n• **Events** – Weddings, celebrations\n• **Location & contact**\n\nWhat would you like to know more about?",
        ];
    }

    private function handleAvailability(string $message): array
    {
        $date = $this->extractDate($message);
        $time = $this->extractTime($message);
        $guests = $this->extractGuests($message);
        $section = $this->extractSection($message);

        if (!$date || !$guests) {
            $missing = [];
            if (!$date) $missing[] = 'the **date** (e.g. April 20, tomorrow, Saturday)';
            if (!$guests) $missing[] = 'the **number of guests**';
            if (!$section) $missing[] = 'the **section** (interior or terrace)';
            if (!$time) $missing[] = 'the **time** (e.g. 2:00 PM, 9:30 PM)';

            return [
                'reply' => "To check availability, I need:\n\n• " . implode("\n• ", $missing) . "\n\nExample: \"Is there a table for 4 on Saturday at 9 PM on the terrace?\"",
            ];
        }

        $section = $section ?? 'interior';
        $time = $time ?? '14:00';

        $hour = (int) date('H', strtotime($time));
        if ($hour >= 1 && $hour < 9) {
            return [
                'reply' => "The restaurant is closed at that hour. Our hours are **9:00 AM to 12:00 AM**. Would you like to try another time?",
            ];
        }

        $tables = Table::where('section', $section)
            ->where('capacity', '>=', $guests >= 7 ? 7 : $guests)
            ->orderBy('table_number')
            ->get();

        $timeFrom = date('H:i', strtotime($time) - 7140);
        $timeTo = date('H:i', strtotime($time) + 7140);

        $reservedTableNumbers = Reservation::where('date', $date)
            ->where('time', '>=', $timeFrom)
            ->where('time', '<=', $timeTo)
            ->whereNotNull('table_number')
            ->pluck('table_number')
            ->toArray();

        $available = $tables->filter(fn($t) => !in_array($t->table_number, $reservedTableNumbers));
        $formattedDate = Carbon::parse($date)->format('l, F j');

        if ($available->isEmpty()) {
            return [
                'reply' => "Sorry, there are no tables available in the **{$section}** section for **{$guests} guests** on **{$formattedDate}** at **{$time}**.\n\nWould you like to try a different date, time or section?",
            ];
        }

        $tableList = $available->map(fn($t) => "• Table {$t->table_number} (capacity: {$t->capacity} guests)")->implode("\n");

        return [
            'reply' => "✅ Great news! There are **{$available->count()} table(s)** available in the **{$section}** section for **{$guests} guests** on **{$formattedDate}** at **{$time}**:\n\n{$tableList}\n\nWould you like to make a reservation?",
            'type' => 'action',
            'data' => ['link' => '/table/', 'label' => 'Book now'],
        ];
    }

    private function handleUserReservations($user): array
    {
        if (!$user) {
            return [
                'reply' => "You need to be logged in to view your reservations.",
                'type' => 'action',
                'data' => ['link' => '/login/', 'label' => 'Log in'],
            ];
        }

        $reservations = Reservation::where('user_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        if ($reservations->isEmpty()) {
            return [
                'reply' => "You don't have any active reservations at the moment. Would you like to make one?",
                'type' => 'action',
                'data' => ['link' => '/table/', 'label' => 'Make a reservation'],
            ];
        }

        $list = $reservations->map(function ($r) {
            $date = Carbon::parse($r->date)->format('l, F j');
            if (!empty($r->event_slug)) {
                $title = $r->event_title ?: ucwords(str_replace('-', ' ', $r->event_slug));
                return "• **{$date}** at {$r->time} – {$r->guests} guests · 🎉 Event: {$title}";
            }
            $table = $r->table_number ? " · Table {$r->table_number}" : '';
            $section = $r->section ? ' · ' . ucfirst($r->section) : '';
            return "• **{$date}** at {$r->time} – {$r->guests} guests{$section}{$table}";
        })->implode("\n");

        return [
            'reply' => "📋 You have **{$reservations->count()} active reservation(s)**:\n\n{$list}\n\nNeed to cancel any of them?",
            'type' => 'action',
            'data' => ['link' => '/my-reservations/', 'label' => 'Manage reservations'],
        ];
    }

    private function handleRoomInfo(string $message): array
    {
        $rooms = $this->knowledge['rooms'];

        if ($this->matchesIntent($message, ['exceptional', 'butler', 'ultimate luxury', 'finest'])) {
            $r = $rooms['exceptional'];
            return [
                'reply' => "👑 **{$r['name']}**\n\n{$r['features']}\n\nThe highest expression of hospitality at Maison Dune.",
                'type' => 'action',
                'data' => ['link' => '/exceptional-suites/', 'label' => 'View Exceptional Suites'],
            ];
        }

        if ($this->matchesIntent($message, ['suite'])) {
            $r = $rooms['suite'];
            return [
                'reply' => "🏛️ **{$r['name']}**\n\n{$r['features']}",
                'type' => 'action',
                'data' => ['link' => '/suites/', 'label' => 'View Suites'],
            ];
        }

        $reply = "🏨 **Accommodation at Maison Dune:**\n\n";
        foreach ($rooms as $r) {
            $size = isset($r['size']) ? " ({$r['size']})" : '';
            $reply .= "• **{$r['name']}**{$size}: {$r['features']}\n\n";
        }
        $reply .= "Which type would you like to know more about?";

        return [
            'reply' => $reply,
            'type' => 'action',
            'data' => ['link' => '/rooms/', 'label' => 'View rooms'],
        ];
    }

    private function handleAccountInfo(string $message): array
    {
        if ($this->matchesIntent($message, ['password', 'forgot', 'recover', 'reset password'])) {
            return [
                'reply' => "To recover your password:\n\n1. Go to the login page.\n2. Click on **\"Forgot password?\"**.\n3. Enter your registered email.\n4. You'll receive a link to create a new password.",
                'type' => 'action',
                'data' => ['link' => '/forgot-password/', 'label' => 'Reset password'],
            ];
        }

        if ($this->matchesIntent($message, ['verify', 'verification'])) {
            return [
                'reply' => "After signing up, you'll receive a verification email. Click the link to activate your account. If you can't find it, check your spam folder.\n\nYou won't be able to log in or make reservations without verifying your email.",
            ];
        }

        if ($this->matchesIntent($message, ['sign up', 'register', 'create account'])) {
            return [
                'reply' => "To create your account:\n\n1. Go to the registration page.\n2. Choose a username (no spaces).\n3. Enter your email and password.\n4. Verify your email by clicking the link you'll receive.",
                'type' => 'action',
                'data' => ['link' => '/register/', 'label' => 'Create account'],
            ];
        }

        return [
            'reply' => "Need help with your account? I can assist you with:\n\n• Creating a new account\n• Logging in\n• Recovering your password\n• Email verification\n\nWhat do you need?",
        ];
    }

    private function matchesIntent(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (mb_strpos($message, mb_strtolower($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }

    private function getTimeGreeting(): string
    {
        $hour = (int) now()->format('H');
        if ($hour < 12) return 'Good morning';
        if ($hour < 18) return 'Good afternoon';
        return 'Good evening';
    }

    private function extractDate(string $message): ?string
    {
        $months = [
            'january' => 1, 'february' => 2, 'march' => 3, 'april' => 4,
            'may' => 5, 'june' => 6, 'july' => 7, 'august' => 8,
            'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12,
        ];

        if (preg_match('/(' . implode('|', array_keys($months)) . ')\s+(\d{1,2})(?:st|nd|rd|th)?/i', $message, $m)) {
            $month = $months[mb_strtolower($m[1])];
            $day = (int) $m[2];
            $year = now()->year;
            $date = Carbon::createFromDate($year, $month, $day);
            if ($date->isPast() && $date->diffInDays(now()) > 1) {
                $date->addYear();
            }
            return $date->toDateString();
        }

        if (preg_match('/(\d{1,2})(?:st|nd|rd|th)?\s+(?:of\s+)?(' . implode('|', array_keys($months)) . ')/i', $message, $m)) {
            $day = (int) $m[1];
            $month = $months[mb_strtolower($m[2])];
            $year = now()->year;
            $date = Carbon::createFromDate($year, $month, $day);
            if ($date->isPast() && $date->diffInDays(now()) > 1) {
                $date->addYear();
            }
            return $date->toDateString();
        }

        if (preg_match('/(\d{1,2})[\/\-](\d{1,2})(?:[\/\-](\d{2,4}))?/', $message, $m)) {
            $day = (int) $m[1];
            $month = (int) $m[2];
            $year = isset($m[3]) ? (int) $m[3] : now()->year;
            if ($year < 100) $year += 2000;
            return Carbon::createFromDate($year, $month, $day)->toDateString();
        }

        if (preg_match('/\b(today|tomorrow|day after tomorrow)\b/i', $message, $m)) {
            $word = mb_strtolower($m[1]);
            if ($word === 'today') return now()->toDateString();
            if ($word === 'tomorrow') return now()->addDay()->toDateString();
            return now()->addDays(2)->toDateString();
        }

        $days = [
            'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
            'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 0,
        ];
        foreach ($days as $dayName => $dayNum) {
            if (mb_strpos($message, $dayName) !== false) {
                return now()->next($dayNum)->toDateString();
            }
        }

        return null;
    }

    private function extractTime(string $message): ?string
    {
        if (preg_match('/(\d{1,2})[:\.](\d{2})\s*(am|pm)?/i', $message, $m)) {
            $h = (int) $m[1];
            $min = (int) $m[2];
            if (!empty($m[3])) {
                $period = mb_strtolower($m[3]);
                if ($period === 'pm' && $h < 12) $h += 12;
                if ($period === 'am' && $h === 12) $h = 0;
            }
            return sprintf('%02d:%02d', $h, $min);
        }
        if (preg_match('/at\s+(\d{1,2})\s*(am|pm)?/i', $message, $m)) {
            $h = (int) $m[1];
            if (!empty($m[2])) {
                $period = mb_strtolower($m[2]);
                if ($period === 'pm' && $h < 12) $h += 12;
                if ($period === 'am' && $h === 12) $h = 0;
            }
            return sprintf('%02d:00', $h);
        }
        return null;
    }

    private function extractGuests(string $message): ?int
    {
        if (preg_match('/(\d+)\s*(?:guest|guests|people|person|persons|pax|diners)/i', $message, $m)) {
            return (int) $m[1];
        }
        if (preg_match('/(?:for|of)\s*(\d+)/i', $message, $m)) {
            return (int) $m[1];
        }
        if (preg_match('/table\s*(?:for|of)\s*(\d+)/i', $message, $m)) {
            return (int) $m[1];
        }
        return null;
    }

    private function extractSection(string $message): ?string
    {
        if ($this->matchesIntent($message, ['terrace', 'outdoor', 'outside', 'patio', 'al fresco'])) {
            return 'terrace';
        }
        if ($this->matchesIntent($message, ['interior', 'inside', 'indoor', 'indoors'])) {
            return 'interior';
        }
        return null;
    }
}
