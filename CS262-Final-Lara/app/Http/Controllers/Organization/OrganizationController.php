<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{


    public function getAllBuyers()
{
    // Get the logged in organization
    $organization = auth('organization-api')->user();
    // Get th id of the logged in organization
    $organizationId = $organization->org_id;

    // Get the list of the buyers for specific event
    $buyerList = DB::table('user')
            ->join('ticket', 'user.user_id', '=', 'ticket.user_id')
            ->join('event', 'ticket.user_id', '=', 'event.event_id')
            ->join('payment', 'payment.payment_id', '=', 'ticket.payment_id')
            ->where('event.org_id', $organizationId)
            ->select(
                'user.username',
                'user.user_id',
                'payment.quantity',
                'payment.amount',
                'payment.payment_date',
                'event.title as event_name'
            )->get();

    return response()->json([
        'buyers' => $buyerList
    ]);
}

public function transaction(Request $request)
{
    // Tell the program to find the keyword no matter the position of the keyword
    $keyword = "%" . $request->keyword . "%";

    $transactionList = DB::table('transaction')
        ->join('user', 'user.org_id', '=', 'transaction.org_id')
        ->join('event', 'event.event_id', '=', 'transaction.event_id')
        ->join('payment', 'payment.payment_id', '=', 'transaction.payment_id')
        ->select(
            'transaction.created_at as date',
            'user.username as user',
            'event.title as event',
            'payment.amount'
        )
        ->when($request->has('keyword'), function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('user.username', 'like', $keyword)
                ->orWhere('event.title', 'like', $keyword);
            });
        })
        ->groupBy(
            'transaction.created_at',
            'user.username',
            'event.title',
            'payment.amount'
        )
        ->orderByDesc('transaction.created_at')
        ->get();

    return response()->json([
        'transactions' => $transactionList
    ]);
}

    public function checkIn(Request $request)
    {
        // Need the unique code for check in
        $request->validate([
            'ticket_code' => 'required|exists:ticket,ticket_code',
        ]);

        // Find the ticket
        $ticket = DB::table('ticket')
            ->where('ticket_code', $request->ticket_code)
            ->first();

        if (!$ticket) {
            return response()->json(['message' => 'Invalid ticket code.'], 404);
        }

        // Check if already checked in
        $alreadyCheckedIn = DB::table('checkin_log')
            ->where('ticket_code', $ticket->ticket_code)
            ->exists();

        if ($alreadyCheckedIn) {
            return response()->json(['message' => 'Ticket already checked in.'], 409);
        }

        // Get the ticket's id
        $ticketId = $ticket->ticket_id;

        // Insert the ticket's info and code to make sure the ticket can be checked in once
        DB::table('checkin_log')->insert([
            'ticket_id'     => $ticketId,
            'ticket_code'   => $ticket->ticket_code,
            'user_id'       => $ticket->user_id,
            'event_id'      => $ticket->event_id,
            'checked_in_at' => now(),
        ]);

        return response()->json([
            'message' => 'Check-in successful.',
            'event_id' => $ticket->event_id,
            'user_id' => $ticket->user_id,
        ]);
    }

    public function profile()
    {

        // Get the logged in organization
        $organization = Auth::guard('organization-api')->user();

        // Get the logged in organization's id
        $organizationId = $organization->org_id;

        // Get the logged in organization's info
        $organizationInfo = DB::table('organization')->where('org_id',$organizationId)->get();


        // Return a proper JSON response (as key-value)
        return response()->json([
            'organization_information' => $organizationInfo
        ]);
    }

}
