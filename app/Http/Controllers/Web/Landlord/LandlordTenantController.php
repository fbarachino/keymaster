<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Unit;
use App\Models\Lease;
use Illuminate\Http\Request;

class LandlordTenantController extends Controller
{
    public function index(Request $request)
    {
        $landlordId = $request->user()->id;

        // Tenant registrati ma senza contratto con questo landlord
        $tenants = User::where('role', 'tenant')
            ->whereDoesntHave('leases.unit.property', function ($q) use ($landlordId) {
                $q->where('landlord_id', $landlordId);
            })
            ->get();

        return view('landlord.tenants.index', compact('tenants'));
    }

    public function assignForm(User $tenant, Request $request)
    {
        $landlordId = $request->user()->id;

        // Unità disponibili del landlord
        $units = Unit::whereHas('property', function ($q) use ($landlordId) {
            $q->where('landlord_id', $landlordId);
        })
        ->whereDoesntHave('lease') // unità non già affittate
        ->get();

        return view('landlord.tenants.assign', compact('tenant', 'units'));
    }

    public function assignStore(User $tenant, Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        Lease::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $data['unit_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'rent_amount' => $data['rent_amount'],
            'deposit_amount' => $data['deposit_amount'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('landlord.tenants.index')
            ->with('success', 'Contratto assegnato con successo.');
    }
}
