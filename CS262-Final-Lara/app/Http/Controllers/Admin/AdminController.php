<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function getAllOrganizations()
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

    public function getAllUsers()
    {
        $totalUsers = DB::table('user')->count();
        $newUsers = DB::table('user')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)
        ->count();
        $totalBalance = DB::table('user')->sum('balance');
        $userList = DB::table('user')->get();

        return response()->json([
            'total_users' => $totalUsers,
            'new_users_this_month' => $newUsers,
            'total_balance' => $totalBalance,
            'users' => $userList
        ]);
    }

    public function transaction(Request $request)
{
    $keyword = $request->keyword;
    $filterBy30Days = $request->has('last_30_days');

    // Summary counts
    $totalEvents = DB::table('event')->count();
    $totalOrganizations = DB::table('organization')->count();
    $totalTicketSold = DB::table('ticket')->count();


    $transactionQuery = DB::table('transaction')
        ->join('organization', 'organization.org_id', '=', 'transaction.org_id')
        ->join('event', 'event.event_id', '=', 'transaction.event_id')
        ->join('payment', 'payment.payment_id', '=', 'transaction.payment_id')
        ->select(
            'transaction.created_at as date',
            'organization.org_name as organization',
            'event.title as event',
            DB::raw('SUM(payment.quantity) as ticket_sold'),
            'transaction.commission_amount as commission'
        );

    // Apply keyword filter if provided
    if (!empty($keyword)) {
        $transactionQuery->where(function ($q) use ($keyword) {
            $q->where('organization.org_name', 'like', '%' . $keyword . '%')
              ->orWhere('event.title', 'like', '%' . $keyword . '%');
        });
    }

    // Apply last 30 days filter if requested
    if ($filterBy30Days) {
        $date30DaysAgo = now()->subDays(30);
        $transactionQuery->where('transaction.created_at', '>=', $date30DaysAgo);
    }

    // Finalize query
    $transactionList = $transactionQuery
        ->groupBy(
            'transaction.created_at',
            'organization.org_name',
            'event.title',
            'transaction.commission_amount'
        )
        ->orderByDesc('transaction.created_at')
        ->get();

    // Response
    return response()->json([
        'total_event' => $totalEvents,
        'total_organization' => $totalOrganizations,
        'ticket_sold' => $totalTicketSold,
        'transactions' => $transactionList
    ]);
}


    public function dashboard()
    {
        // Counts for total users, total organizations, total ticket sold
        $totalUsers = DB::table('user')->count();
        $totalOrganizations = DB::table('organization')->count();
        $ticketSold = DB::table('ticket')->count();

        // Get the revenue by calculating the sum of all amount paid in the payment table
        $totalRevenue = DB::table('payment')->where('payment_status', 'paid')->sum('amount');

        // Get all the active events
        $eventList = DB::table('event')->where('status', 'active')->get();
        $topEventsByTicket = DB::table('ticket')
            ->join('event', 'event.event_id', '=', 'ticket.event_id')
            ->groupBy('event.event_id','event.title')
            ->select('event.title', DB::raw('COUNT(ticket.ticket_id) as total_tickets_sold'))
            ->orderByDesc('total_tickets_sold')
            ->get();

        return response()->json([
            'total_users' => $totalUsers,
            'total_organizations' => $totalOrganizations,
            'ticket_sold' => $ticketSold,
            'total_revenue' => $totalRevenue,
            'event_list'=> $eventList,
            'top_events_by_ticket_sold' => $topEventsByTicket
        ]);
    }

    public function activityLog()
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
                    'date' => $log->created_at,
                    'detail' => $log->description,
                    'activity' => $log->event,
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

        $adminId = $admin->admin_id;

        $adminInfo = DB::table('admin')->where('admin_id', $adminId)->get();

        return response()->json([
            'admin_information' => $adminInfo
        ]);
    }
}
