<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\User;
use App\Models\Unit;
use App\Models\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantManagementController extends Controller
{
    public function create()
    {
        // Mostra form per creare inquilino + contratto
        $units = Unit::where('status', 'available')
            ->whereHas('property', fn($q) =>
                $q->where('landlord_id', auth()->id())
            )->get();

        return view('landlord.tenants.create', compact('units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Dati inquilino
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',

            // Dati contratto
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
        ]);

        // 1) Creazione inquilino
        $tenant = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'tenant',
        ]);

        // 2) Creazione contratto
        Lease::create([
            'unit_id' => $data['unit_id'],
            'tenant_id' => $tenant->id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'rent_amount' => $data['rent_amount'],
            'deposit_amount' => $data['deposit_amount'] ?? 0,
            'status' => 'active',
        ]);

        // 3) Aggiorna stato unità
        Unit::where('id', $data['unit_id'])->update(['status' => 'occupied']);

        return redirect()->route('leases.index')
            ->with('success', 'Inquilino creato e contratto assegnato con successo.');
    }
}
