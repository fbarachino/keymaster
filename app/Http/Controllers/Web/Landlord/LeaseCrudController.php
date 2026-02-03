<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use Illuminate\Http\Request;

class LeaseCrudController extends Controller
{
    public function index(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $leases = $property->leases()
            ->with('units', 'tenants')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('landlord.leases.index', compact('property', 'leases'));
    }

    public function create(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $units = $property->units;
        $tenants = Tenant::orderBy('name')->get();

        return view('landlord.leases.create', compact('property', 'units', 'tenants'));
    }

    public function store(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'rent_total' => 'required|numeric',
            'advance_expense' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',

            'split_mode' => 'required|in:equal,percentage,fixed,unit_based,custom',
            'status' => 'required|in:active,terminated,pending',

            'notes' => 'nullable|string',

            'units' => 'required|array',
            'units.*' => 'exists:units,id',

            'tenants' => 'required|array',
            'tenants.*' => 'exists:tenants,id',
        ]);

        $data['property_id'] = $property->id;

        $lease = Lease::create($data);

        // Associazione unit
        $lease->units()->sync($data['units']);

        // Associazione tenant
        $lease->tenants()->sync($data['tenants']);

        return redirect()
            ->route('landlord.leases.index', $property)
            ->with('success', 'Contratto creato correttamente.');
    }

    public function edit(Property $property, Lease $lease, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeLease($lease, $property);

        $units = $property->units;
        $tenants = Tenant::orderBy('name')->get();

        return view('landlord.leases.edit', compact('property', 'lease', 'units', 'tenants'));
    }

    public function update(Property $property, Lease $lease, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeLease($lease, $property);

        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'rent_total' => 'required|numeric',
            'advance_expense' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',

            'split_mode' => 'required|in:equal,percentage,fixed,unit_based,custom',
            'status' => 'required|in:active,terminated,pending',

            'notes' => 'nullable|string',

            'units' => 'required|array',
            'units.*' => 'exists:units,id',

            'tenants' => 'required|array',
            'tenants.*' => 'exists:tenants,id',
        ]);

        $lease->update($data);

        $lease->units()->sync($data['units']);
        $lease->tenants()->sync($data['tenants']);

        return redirect()
            ->route('landlord.leases.index', $property)
            ->with('success', 'Contratto aggiornato correttamente.');
    }

    public function destroy(Property $property, Lease $lease, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeLease($lease, $property);

        $lease->delete();

        return redirect()
            ->route('landlord.leases.index', $property)
            ->with('success', 'Contratto eliminato.');
    }

    private function authorizeProperty(Property $property, Request $request)
    {
        $landlord = $request->user()->landlord;

        if (!$property->landlords->contains($landlord->id)) {
            abort(403, 'Non sei autorizzato ad accedere a questa proprietà.');
        }
    }

    private function authorizeLease(Lease $lease, Property $property)
    {
        if ($lease->property_id !== $property->id) {
            abort(403, 'Questo contratto non appartiene a questa proprietà.');
        }
    }
}
