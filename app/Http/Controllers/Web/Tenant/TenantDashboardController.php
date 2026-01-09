<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Lease;
use App\Models\Payment;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user();

        $leases = Lease::where('tenant_id', $tenant->id)->with('unit.property')->get();
        $pending = Payment::whereHas('lease', fn($q) =>
            $q->where('tenant_id', $tenant->id)
        )->where('status', 'pending')->count();

        $unread = Message::where('receiver_id', $tenant->id)
            ->whereNull('read_at')
            ->count();

        // Ticket aperti
        $openTickets = Ticket::where('tenant_id', $tenant->id) ->where('status', 'open') ->count();
        // Note ai ticket (solo note NON interne)
        $ticketNotes = TicketNote::whereHas('ticket', function ($q) use ($tenant) {
             $q->where('tenant_id', $tenant->id);
             }) ->where('is_internal', false) ->latest() ->take(5) ->get();
        // Messaggi ricevuti dal landlord
        $messages = Message::where('tenant_id', $tenant->id) ->where('sender', 'landlord') ->latest() ->take(5) ->get();

        return view('tenant.dashboard', compact( 'openTickets', 'ticketNotes', 'messages', 'leases', 'pending', 'unread'));

        // return view('tenant.dashboard', compact('leases', 'pending', 'unread'));
    }
}
