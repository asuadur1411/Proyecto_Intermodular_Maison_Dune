<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\RoomReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomReviewController extends Controller
{
    public function index(Request $request, string $slug)
    {
        $reviews = RoomReview::where('room_slug', $slug)
            ->orderByDesc('created_at')
            ->get(['id', 'user_id', 'user_name', 'rating', 'comment', 'created_at']);

        $count = $reviews->count();
        $avg   = $count ? round($reviews->avg('rating'), 1) : 0;

        $canReview = false;
        $alreadyReviewed = false;
        $authUser = Auth::guard('sanctum')->user();
        $authUserId = $authUser ? $authUser->id : null;
        if ($authUser) {
            $canReview = Reservation::where('user_id', $authUser->id)
                ->where('room_slug', $slug)
                ->exists();
            $alreadyReviewed = RoomReview::where('user_id', $authUser->id)
                ->where('room_slug', $slug)
                ->exists();
        }

        $items = $reviews->map(function ($r) use ($authUserId) {
            return [
                'id'         => $r->id,
                'user_name'  => $r->user_name,
                'rating'     => $r->rating,
                'comment'    => $r->comment,
                'created_at' => $r->created_at,
                'is_mine'    => $authUserId !== null && (int) $r->user_id === (int) $authUserId,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => [
                'count'            => $count,
                'average'          => $avg,
                'items'            => $items,
                'can_review'       => $canReview,
                'already_reviewed' => $alreadyReviewed,
            ],
        ]);
    }

    public function store(Request $request, string $slug)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $user = Auth::user();

        // Gate: only guests who have actually booked this room can review it.
        $hasBooked = Reservation::where('user_id', $user->id)
            ->where('room_slug', $slug)
            ->exists();

        if (!$hasBooked) {
            return response()->json([
                'success' => false,
                'message' => 'Only guests who have booked this room can leave a review.',
            ], 403);
        }

        // One review per user per room — update if exists, else create.
        $review = RoomReview::updateOrCreate(
            ['room_slug' => $slug, 'user_id' => $user->id],
            [
                'user_name' => $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->email,
                'rating'    => $validated['rating'],
                'comment'   => $validated['comment'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review!',
            'data'    => $review,
        ], 201);
    }

    public function destroy(Request $request, string $slug, int $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $review = RoomReview::where('id', $id)
            ->where('room_slug', $slug)
            ->first();

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Review not found.'], 404);
        }

        // Ownership check — only the author (or an admin) may delete.
        $isAdmin = !empty($user->is_admin);
        if ((int) $review->user_id !== (int) $user->id && !$isAdmin) {
            return response()->json(['success' => false, 'message' => 'You can only delete your own review.'], 403);
        }

        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted.']);
    }
}
