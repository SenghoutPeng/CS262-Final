<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{

public function buyTicket(Request $request)
{
    $request->validate([
        'event_id' => 'required|exists:event,event_id',
        'quantity' => 'required|integer|min:1',
    ]);

    $user = Auth::user();
    $event = DB::table('event')->where('event_id', $request->event_id)->first();

    if (!$event) {
        return response()->json(['error' => 'Event not found'], 404);
    }

    // Check if enough tickets available
    if ($event->total_ticket < $request->quantity) {
        return response()->json(['error' => 'Not enough tickets available'], 400);
    }

    // Calculate total price
    $totalPrice = $event->ticket_price * $request->quantity;

    // Check user balance
    if ($user->balance < $totalPrice) {
        return response()->json(['error' => 'Insufficient balance'], 400);
    }

    // Deduct balance
    DB::table('user')->where('user_id', $user->user_id)->update([
        'balance' => $user->balance - $totalPrice
    ]);

    // Create payment
    $paymentId = DB::table('payment')->insertGetId([
        'user_id' => $user->user_id,
        'event_id' => $event->event_id,
        'amount' => $totalPrice,
        'quantity' => $request->quantity,
        'payment_status' => 'Completed',
        'payment_date' => now(),
    ]);

    $checkInCodes = [];

    for ($i = 0; $i < $request->quantity; $i++) {

        $code = Str::uuid();
        $checkInCodes[] = $code;

        DB::table('ticket')->insert([
            'user_id' => $user->user_id,
            'event_id' => $event->event_id,
            'payment_id' => $paymentId,
            'purchase_date' => now(),
            'ticket_code' => $code,
            'total_price' => $event->ticket_price,
        ]);
    }


    DB::table('event')->where('event_id', $event->event_id)->update([
        'total_ticket' => $event->total_ticket - $request->quantity
    ]);

    return response()->json(['message' => 'Ticket(s) purchased successfully','checkin_codes'=>$checkInCodes]);
}


    public function showRatingForm()
    {
        $rating_category_db = DB::select('select
        rating_category_name from rating_category
        ');
        return response()->json(['rating_category'=>$rating_category_db]);
    }

    public function rating(Request $request)
    {

        $request->validate(
            [
                'rating_category_id' =>'required|exists:rating_category, rating_category_id'
            ]
        );

        $rating_db = DB::select('select ',);
    }
    public function profile()
    {
        // Get the currently logged-in user user
        $user = Auth::guard()->user();

        // You want the user ID
        $user_id = $user->user_id;

        $user_db = DB::select("SELECT * FROM user WHERE user_id = ?", [$user_id]);

        return response()->json([
            'user_information' => $user_db
        ]);
    }
}
