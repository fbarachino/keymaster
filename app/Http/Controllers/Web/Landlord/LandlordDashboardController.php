<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LandlordDashboardController extends Controller
{
    public function index(Request $request)
    {
        $driver = DB::getDriverName();

    $monthExpr = $driver === 'sqlite'
    ? "strftime('%m', date)"
    : "MONTH(date)";
    $monthDueExpr = $driver === 'sqlite'
    ? "strftime('%m', due_date)"
    : "MONTH(due_date)";

        $landlord = $request->user();

        // Pagamenti per mese
        $payments = Payment::whereHas('lease.unit.property', fn($q) =>
            $q->where('landlord_id', $landlord->id)
        )
        ->selectRaw("$monthDueExpr as month, SUM(amount) as total")
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Contratti attivi
        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $landlord->id)
        )->count();

        // Spese mensili



        $monthlyExpenses = Expense::whereHas('lease.unit.property', fn($q) =>
    $q->where('landlord_id', auth()->id())
)
->selectRaw("$monthExpr as month, SUM(amount) as total")
->groupBy('month')
->pluck('total', 'month');

//return view('landlord.dashboard', compact('payments', 'leases', 'monthlyExpenses'));


        return view('landlord.dashboard', compact('payments', 'leases', 'monthlyExpenses'));
    }

}
