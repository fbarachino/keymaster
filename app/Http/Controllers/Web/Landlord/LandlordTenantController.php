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

   /*  public function index()
    {
        $tenants = User::where('role', 'tenant')->get();
        return view('landlord.tenants.index', compact('tenants'));
    }
 */
    public function create(Request $request)
    {
        $landlordId = $request->user()->id;

        // Lease appartenenti al landlord
        $leases = Lease::whereHas('unit.property', function ($q) use ($landlordId) {
            $q->where('landlord_id', $landlordId);
        })->get();

        return view('landlord.tenants.create', compact('leases'));
    }

/*     public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'lease_id' => 'nullable|exists:leases,id',
        ]);

        // crea il tenant
        $tenant = User::create([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'password' => bcrypt(str()->random(12)),
            'role' => 'tenant',
        ]);

        // collega alla lease se selezionata
        if ($request->lease_id) {
            $lease = Lease::find($request->lease_id);
            $lease->tenants()->syncWithoutDetaching([$tenant->id]);
        }

        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Tenant creato correttamente.');
    } */

            public function store(Request $request)
{
    $validated = $request->validate([
        'email'      => 'required|email|unique:users,email',
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'lease_id'   => 'nullable|exists:leases,id',
    ]);

    // crea il tenant
    $tenant = User::create([
        'email'      => $validated['email'],
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'password'   => bcrypt(str()->random(12)),
        'role'       => 'tenant',
    ]);

    // collega alla lease se selezionata
    if ($request->lease_id) {
        $lease = Lease::find($request->lease_id);
        $lease->tenants()->syncWithoutDetaching([$tenant->id]);
    }

    return redirect()->route('landlord.tenants.index')
        ->with('success', 'Tenant creato correttamente.');
}

}
