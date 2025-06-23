<?php

namespace App\Http\Controllers\Organization;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function createEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric',
            'total_ticket' => 'required|integer',
            'event_category_id' => 'required|exists:event_category,event_category_id',
            'proposed_date' => 'required|date',
            'event_time' => 'required|date_format:H:i:s',
            'banner' => 'nullable',
        ]);

        $organization = $request->user();

        $event = Event::create(array_merge(
            $validated,
            ['org_id' => $organization->org_id]
        ));

        return response()->json(['message' => 'Event requested successfully', 'event' => $event]);
    }


    public function showBuyer()

    {   $organization = auth('organization')->user();
        $organization_id = $organization->org_id;
        $listofbuyer = DB::select(
            'select
                user.username, ticket.quantity, payment.amount,event.event_name,payment.status
            FROM
                user
             INNER JOIN ticket ON user.user_id = ticket.user_id
            INNER JOIN event ON ticket.event_id = event.event_id
             INNER JOIN payment ON payment.ticket_id = ticket.ticket_id
            WHERE event.org_id = ? ',[$organization_id]);
        return response()->json([
            'List of buyers',$listofbuyer
        ]);
    }
    public function checkIn(Request $request)
    {
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


        $ticketId = $ticket->ticket_id;


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

        $organization = Auth::guard('organization-api')->user();


        $organization_id = $organization->org_id;
        // Use parameter binding to prevent SQL injection
        $organization_db = DB::select("SELECT * FROM organization WHERE org_id = ?", [$organization_id]);

        // Return a proper JSON response (as key-value)
        return response()->json([
            'organization_information' => $organization_db
        ]);
    }

}
