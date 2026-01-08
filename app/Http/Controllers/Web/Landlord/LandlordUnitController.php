<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordUnitController extends Controller
{
    public function show(Request $request, Unit $unit)
    {
        abort_if($unit->property->landlord_id !== $request->user()->id, 403);

        return $unit->load(['property', 'lease.tenant']);
    }

    public function available(Request $request)
    {
        $landlordId = $request->user()->id;
        $units = Unit::whereHas('property', function ($q) use ($landlordId) {
            $q->where('landlord_id', $landlordId);
        })
            ->whereDoesntHave('leases') // nessun contratto attivo
            ->with('property')
            ->get();

        return view('landlord.units.available', compact('units'));
    }
}
