<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Property;
use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordDashboardController extends Controller
{
    public function index(Request $request)
    {
        $landlord = $request->user();

        // Pagamenti per mese
        $payments = Payment::whereHas('lease.unit.property', fn($q) =>
            $q->where('landlord_id', $landlord->id)
        )
        ->selectRaw('strftime("%m", due_date) as month, SUM(amount) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Contratti attivi
        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $landlord->id)
        )->count();

        return view('landlord.dashboard', compact('payments', 'leases'));
    }

}
