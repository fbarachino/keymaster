<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    

class MaintenanceDashboardController extends Controller
{
    public function index(Request $request)
{
    $landlord = $request->user();

    $tickets = Ticket::whereHas('unit.property', fn($q) =>
        $q->where('landlord_id', $landlord->id)
    )->with(['tenant', 'unit'])->get();

    $stats = [
        'open' => $tickets->where('status', 'open')->count(),
        'in_progress' => $tickets->where('status', 'in_progress')->count(),
        'closed' => $tickets->where('status', 'closed')->count(),
    ];

    return view('landlord.maintenance.dashboard', compact('tickets', 'stats'));
}
}
