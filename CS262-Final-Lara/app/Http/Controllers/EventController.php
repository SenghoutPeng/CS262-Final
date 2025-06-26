<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function searchEvent(Request $request)
    {
        $keyword = "%" . $request->keyword . "%";

        $events = DB::table('event')->whereAny(['title', 'description'], 'like', $keyword)->orderBy('title')->get();


        return response()->json([
            'result' => $events
        ]);

    }
    public function filterEvent(Request $request)
    {
        $filter = $request->filter;

        $events = DB::table('event')
            ->join('event_category', 'event_category.event_category_id', '=', 'event.event_category_id')->whereAny(['event_category_name'],'like', $filter);

        return response()->json([
            'result' => $events
        ]);
    }
    public function getAllEvents()
    {
        $event = DB::table('event')->get();

        return response()->json([
            'event' => $event
        ]);
    }
    public function getOneEvent(Request $request)
    {
        $eventId = $request->event_id;

        $eventDetail = DB::table('event')->where('event_id',$eventId)->get();
        return response()->json([
            'event_detail' => $eventDetail
        ]);
    }
    public function createEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'ticket_price' => 'required|numeric',
            'total_ticket' => 'required|integer',
            'event_category_id' => 'required|exists:event_category,         event_category_id',
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

    public function getAllEventRequests()
    {
        $eventRequests = DB::table('event')->where('status', 'pending')->join('organization','organization.org_id','=','event.org_id')->select('organization.org_name','event.title','event.created_at', 'event.status');


        return response()->json([
            'event_requests' => $eventRequests
        ]);
    }

    public function getOneEventRequest(Request $request)
    {
        $event_id = $request->event_id;

        $eventRequest = DB::table('event')->where('event_id', $event_id)->select('title','description','location','proposed_date')->first();

        return response()->json([
            'event_request_detail' => $eventRequest
        ]);
    }
    public function approveEventRequest(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'id' => 'required|exists:event,event_id'
        ]);
        $admin = Auth::guard('admin-api')->user();
        $update = DB::table('event')
            ->where('event_id', $validated['id'])
            ->update([
                'admin_id' => $admin->admin_id,
                'status' => $validated['status'],
                'reviewed_at' => now()
            ]);

        return response()->json([
            'message' => 'Event ' . $validated['status']
        ]);
    }

}
