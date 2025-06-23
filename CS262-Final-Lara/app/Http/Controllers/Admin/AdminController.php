<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function allOrganization()
    {
        $totalOrganizations = DB::table('organization')->count();

        $newOrganizations = DB::table('organization')
                        ->whereMonth('created_at',Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->count();

        $organizationList = DB::table('organization')->get();

        $totalBalance = DB::table('organization')->sum('balance');


        return response()->json([
            'total_organizations' => $totalOrganizations,
            'new_organizations_this_month' => $newOrganizations,
            'total_balance' => $totalBalance,
            'organizations' => $organizationList,
        ]);
    }

    public function allUser()
    {
        $totalUsers = DB::table('user')->count();
        $newUsers = DB::table('user')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)
        ->count();
        $totalBalance = DB::table('user')->sum('balance');
        $userList = DB::table('user')->get();

        return response()->json([
            'total_ussers' => $totalUsers,
            'new_users_this_month' => $newUsers,
            'total_balance' => $totalBalance,
            'users' => $userList
        ]);
    }

    public function allEventRequest()
    {
        $eventRequests = DB::table('event')->where('status', 'pending')->get();

        return response()->json([
            'event_requests' => $eventRequests
        ]);
    }

    public function viewEventRequest(Request $request)
    {
        $event_id = $request->event_id;

        $eventRequest = DB::table('event')->where('even_id', $event_id)->select('title','description','location','proposed_date');

        return response()->json([
            'event_request_detail' => $eventRequest
        ]);
    }
    public function decisionOnEventRequest(Request $request)
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

    public function dashboard()
    {
        $totalUsers = DB::table('user')->count();

        $totalOrganizations = DB::table('organization')->count();

        $ticketSold = DB::table('ticket')->count();

        $totalRevenue = DB::table('payment')->where('payment_status', 'paid')->sum('amount');

        // $revenueOfEachEvent = DB::table('payment')
        //                         ->join('event', 'event.event_id', '=', 'payment.event_id')
        //                         ->join('event', 'event.event_id', '=', 'payment.event_id')
        //                         ->where('payment_status','paid')->sum('payment.amount');

        $topEventsByTicket = DB::table('ticket')
            ->join('event', 'event.event_id', '=', 'ticket.event_id')
            ->groupBy('event.event_id','event.title')
            ->select('event.title', DB::raw('SUM(ticket.ticket_id) as total_tickets_sold'))
            ->orderByDesc('total_tickets_sold')
            ->get();
        // $topPerformingEventsByRevenue = $revenueOfEachEvent->sortDesc();


        return response()->json([
            'total_users' => $totalUsers,
            'total_organizations' => $totalOrganizations,
            'ticket_sold' => $ticketSold,
            'total_revenue' => $totalRevenue,
            'top_events_by_ticket_sold' => $topEventsByTicket
        ]);
    }

    public function showActivity()
    {
        $activity_log = DB::table('activity_log')
                ->select('created_at','description','subject_type','event','causer_id','causer_type')
                ->orderBy('created_at', 'desc')
                ->get();

        $all_activity_logs = [];
        foreach ($activity_log as $log) {
            $name = '';
            if ($log->causer_type === 'App\\Models\\User') {
                $name = DB::table('user')->where('user_id', $log->causer_id)->value('username');
            } elseif ($log->causer_type === 'App\\Models\\Organization') {
                $name = DB::table('organization')->where('org_id', $log->causer_id)->value('org_name');
            } elseif ($log->causer_type === 'App\\Models\\Admin') {
                $name = DB::table('admin')->where('admin_id', $log->causer_id)->value('username');
            }


            $all_activity_logs[] =
                [
                    'timestamp' => $log->created_at,
                    'description' => $log->description,
                    'event' => $log->event,
                    'causer_type' => $log->event,
                    'causer_name' => $name
                ];
        }

        return response()->json(
            [
                'all_activity_logs' => $all_activity_logs
            ]
        );
    }
    public function profile()
    {

        $admin = Auth::guard()->user();

        $admin_id = $admin->admin_id;

        $admin_db = DB::select("SELECT * FROM admin WHERE admin_id = ?", [$admin_id]);

        return response()->json([
            'admin_information' => $admin_db
        ]);
    }
}
