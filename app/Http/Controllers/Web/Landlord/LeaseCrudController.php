<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaseCrudController extends Controller
{
    public function index(Request $request)
    {
        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $request->user()->id)
        )->with(['unit.property', 'tenant'])->get();

        return view('landlord.leases.index', compact('leases'));
    }

    public function create()
    {
        $units = Unit::whereHas('property', fn($q) =>
            $q->where('landlord_id', auth()->id())
        )->get();

        $tenants = User::where('role', 'tenant')->get();

        return view('landlord.leases.create', compact('units', 'tenants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
        ]);

        Lease::create($data);

        return redirect()->route('landlord.leases.index')
            ->with('success', 'Contratto creato con successo.');
    }

    public function edit(Lease $lease)
    {
        // Sicurezza: il contratto deve appartenere al landlord
        abort_if($lease->unit->property->landlord_id !== auth()->id(), 403);

        $units = Unit::whereHas('property', fn($q) =>
            $q->where('landlord_id', auth()->id())
        )->get();

        $tenants = User::where('role', 'tenant')->get();

        return view('landlord.leases.edit', compact('lease', 'units', 'tenants'));
    }

    public function update(Request $request, Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== auth()->id(), 403);

        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
        ]);

        $lease->update($data);

        return redirect()->route('leases.index')
            ->with('success', 'Contratto aggiornato con successo.');
    }

    public function destroy(Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== auth()->id(), 403);

        $lease->delete();

        return redirect()->route('leases.index')
            ->with('success', 'Contratto eliminato.');
    }
}
