<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function makePayment(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:ticket,ticket_id',
        ]);

        $ticket = DB::table('ticket')->where('ticket_id', $request->ticket_id)->first();
        $event = DB::table('event')->where('event_id', $ticket->event_id)->first();

        $amount = $ticket->total_price;
        $commission = $amount * 0.05;


        $payment_id = DB::table('payment')->insertGetId([
            'user_id' => $ticket->user_id,
            'ticket_id' => $ticket->ticket_id,
            'event_id' => $event->event_id,
            'amount' => $amount,
            'paid_at' => now(),
        ]);

        DB::table('transaction')->insert([
            'user_id' => $ticket->user_id,
            'org_id' => $event->org_id,
            'event_id' => $event->event_id,
            'amount' => $amount,
            'commission_amount' => $commission,
            'transaction_date' => now(),
        ]);

        return response()->json(['status' => 'success', 'payment_id' => $payment_id]);
    }

}
