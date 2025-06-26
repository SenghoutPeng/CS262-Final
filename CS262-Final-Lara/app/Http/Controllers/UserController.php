<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        if ($event->status == 'pending') {
            return response()->json(['message' => 'Event has not been approved']);
        }

        if ($event->total_ticket < $request->quantity) {
            return response()->json(['error' => 'Not enough tickets available'], 400);
        }

        $totalPrice = $event->ticket_price * $request->quantity;

        if ($user->balance < $totalPrice) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        // Deduct user balance
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

        // Create as many tickets as the quantity requested and insert them one by one to make sure the payment_id actually applied to each individual ticket
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

        // Get org_id
        $organizationRecord = DB::table('event')
            ->join('organization', 'organization.org_id', '=', 'event.org_id')
            ->where('event.event_id', $request->event_id)
            ->select('organization.org_id')
            ->first();

        $organizationId = $organizationRecord->org_id;

        // Calculate commission
        $commissionAmount = $totalPrice * 0.05;

        // Create transaction
        Transaction::create([
            'amount' => $totalPrice,
            'user_id' => $user->user_id,
            'org_id' => $organizationId,
            'event_id' => $event->event_id,
            'payment_id' => $paymentId,
            'commission_amount' => $commissionAmount
        ]);

        // Update organization balance
        DB::table('organization')->where('org_id', $organizationId)->update([
            'balance' => DB::raw("balance + " . ($totalPrice - $commissionAmount))
        ]);

        // Update event ticket count
        DB::table('event')->where('event_id', $event->event_id)->update([
            'total_ticket' => $event->total_ticket - $request->quantity
        ]);

        // Update admin balance
        DB::table('admin')->where('admin_id', $event->admin_id)->update([
            'balance' => DB::raw("balance + " . $commissionAmount)
        ]);

        return response()->json([
            'message' => 'Ticket(s) purchased successfully',
            'checkin_codes' => $checkInCodes
        ]);
    }


    public function showRatingForm()
    {
        $ratingCategory = DB::table('rating_category')->select('rating_category_name')->get();

        return response()->json(['rating_category'=>$ratingCategory]);
    }


    public function profile()
    {
        // Get the currently logged-in user user
        $user = Auth::guard()->user();

        // Get the logged in user's id
        $userId = $user->user_id;

        // Get the logged in user's information
        $userInfo = DB::table('user')->where('user_id', $userId)->get();

        return response()->json([
            'user_information' => $userInfo
        ]);
    }
}
