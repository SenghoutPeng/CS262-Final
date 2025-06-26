<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function submitRating(Request $request)
    {
        // Rules for validation
        $request->validate([
            'event_id' => 'required|exists:event,event_id',
            'rating' => 'required|array',
            'rating.*.category_id' => 'required|exists:rating_category,rating_category_id',
            'rating.*.value' => 'required|integer|min:1|max:5',
        ]);

        // Get logged in user
        $user = Auth::user();

        // Get the event that user wants to rate
        $event = DB::table('event')->where('event_id', $request->event_id)->first();

        // Check if the event actually exists
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // if the event exists then get the owner of the event
        $organizationId = $event->org_id;

        // Creating the ratings in once the conditions are met
        foreach ($request->rating as $ratingItem) {
            DB::table('rating')->insert([
                'user_id' => $user->user_id,
                'event_id' => $request->event_id,
                'org_id' => $organizationId,
                'rating_category_id' => $ratingItem['category_id'],
                'rating' => $ratingItem['value'], // your rating value column
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Thank you for your feedback!']);
    }

    public function feedback()
    {
        // Get to know which organization is logged in
        $organization = auth('organization-api')->user();

        // Get the id of the logged in organization
        $organizationId = $organization->org_id;

        // Get the rating
        $ratingSummary = DB::table('rating')
            ->join('rating_category', 'rating_category.rating_category_id', '=', 'rating.rating_category_id')
            ->where('ratings.org_id',         $organizationId)
            ->select(
                'rating_category.rating_category_name',
                DB::raw('AVG(rating.rating) as average_rating'),
                DB::raw('COUNT(rating.rating_id) as total_ratings')
            )
            ->groupBy('rating_category.rating_category_name')
            ->get();

        // Get the recent feedback
        $recentFeedback = DB::table('rating')
            ->join('user', 'user.user_id', '=', 'rating.user_id')
            ->join('event', 'event.event_id', '=', 'rating.event_id')
            ->select(
                'rating.created_at as date',
                'user.user_id as customer_id',
                'event.event_name',
                'rating_category_id',
                'rating'
            )
            ->where('rating.org_id',     $organizationId)
            ->orderByDesc('rating.created_at')
            ->limit(10)
            ->get();

        return response()->json([
            'rating_summary' => $ratingSummary,
            'recent_feedback' => $recentFeedback,
        ]);
    }

}
