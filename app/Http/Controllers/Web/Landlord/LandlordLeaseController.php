<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordLeaseController extends Controller
{
    public function index(Request $request)
    {
        return Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $request->user()->id)
        )->with(['unit.property', 'tenant'])->get();
    }

    public function show(Request $request, Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== $request->user()->id, 403);

        $totals = $lease->totals()
            ->orderBy('period_type')
            ->orderBy('period', 'desc')
            ->get();

        $payments = $lease->payments()
            ->with('tenant')
            ->orderBy('due_date')
            ->get();

        return view('landlord.leases.show', compact('lease', 'totals', 'payments'));
        // return $lease->load(['unit.property', 'tenant', 'payments']);
    }
}
