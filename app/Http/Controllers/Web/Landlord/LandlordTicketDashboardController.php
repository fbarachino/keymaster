<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class LandlordTicketDashboardController extends Controller
{
    public function index(Request $request)
    {
        $landlordId = $request->user()->id;

        // Conteggi per stato
        $open = Ticket::where('landlord_id', $landlordId)
            ->where('status', 'open')
            ->count();

        $inProgress = Ticket::where('landlord_id', $landlordId)
            ->where('status', 'in_progress')
            ->count();

        $closed = Ticket::where('landlord_id', $landlordId)
            ->where('status', 'closed')
            ->count();

        // Ticket recenti
        $recent = Ticket::where('landlord_id', $landlordId)
            ->latest()
            ->take(5)
            ->with(['tenant', 'unit.property'])
            ->get();

        return view('landlord.maintenance.dashboard', compact(
            'open',
            'inProgress',
            'closed',
            'recent'
        ));
    }
}
