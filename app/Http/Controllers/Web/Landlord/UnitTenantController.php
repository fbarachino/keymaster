<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;


class UnitTenantController extends Controller
{
    public function index(Property $property, Unit $unit)
    {
        return view('landlord.units.tenants.index', [
            'unit' => $unit,
            'property' => $property,
            'tenants' => $unit->tenants,
            'allTenants' => User::role('tenant')->get(), // se usi ruoli
        ]);
    }

   /*  public function store(Request $request, Property $property, Unit $unit)
    {
        $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'share_type' => 'required',
            'share_value' => 'nullable|numeric',
        ]);

        $unit->tenants()->attach($request->tenant_id, [
            'is_primary' => $request->is_primary ?? false,
            'share_type' => $request->share_type,
            'share_value' => $request->share_value,
        ]);

        return back()->with('success', 'Inquilino aggiunto all’unità.');
    } */
   public function store(Request $request, Property $property, Unit $unit)
{
    $request->validate([
        'tenant_id' => 'required|exists:users,id',
        'share_type' => 'required',
        'share_value' => 'nullable|numeric|min:0|max:1',
    ]);

    // Se la quota è custom, controlliamo la somma totale
    if ($request->share_type === 'custom') {

        $currentTotal = $unit->tenants()
            ->wherePivot('share_type', 'custom')
            ->sum('share_value');

        $newTotal = $currentTotal + ($request->share_value ?? 0);

        if ($newTotal > 1) {
            return back()->withErrors([
                'share_value' => 'La somma delle quote personalizzate supera il 100%.'
            ]);
        }
    }

    $unit->tenants()->attach($request->tenant_id, [
        'is_primary' => $request->is_primary ?? false,
        'share_type' => $request->share_type,
        'share_value' => $request->share_value,
    ]);

    return back()->with('success', 'Inquilino aggiunto all’unità.');
}

   public function calculateShares(Unit $unit, float $amount)
{
    $tenants = $unit->tenants;

    // 1) Coinquilini con quota uguale
    $equalTenants = $tenants->where('pivot.share_type', 'equal');
    $equalCount = $equalTenants->count();

    // 2) Coinquilini con quota custom
    $customTenants = $tenants->where('pivot.share_type', 'custom');

    $shares = [];

    // Quote custom
    foreach ($customTenants as $tenant) {
        $shares[$tenant->id] = $amount * $tenant->pivot->share_value;
    }

    // Quote equal
    if ($equalCount > 0) {
        $equalAmount = ($amount - array_sum($shares)) / $equalCount;

        foreach ($equalTenants as $tenant) {
            $shares[$tenant->id] = $equalAmount;
        }
    }

    // Coinquilini senza quota → ignorati
    return $shares;
}


    public function destroy(Property $property, Unit $unit, User $tenant)
    {
        $unit->tenants()->detach($tenant->id);

        return back()->with('success', 'Inquilino rimosso.');
    }
}
