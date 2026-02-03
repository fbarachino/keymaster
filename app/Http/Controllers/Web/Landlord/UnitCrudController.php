<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitCrudController extends Controller
{
    public function index(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $units = $property->units()->orderBy('name')->paginate(10);

        return view('landlord.units.index', compact('property', 'units'));
    }

    public function create(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        return view('landlord.units.create', compact('property'));
    }

    public function store(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'floor' => 'nullable|integer',
            'size_sqm' => 'nullable|numeric',

            'interior' => 'nullable|string|max:255',
            'rooms' => 'nullable|integer',
            'accessory' => 'nullable|string|max:255',
            'status' => 'required|string|in:available,occupied',
            'monthly_rent' => 'nullable|numeric',

            'notes' => 'nullable|string',
        ]);


        $data['property_id'] = $property->id;

        Unit::create($data);

        return redirect()
            ->route('landlord.units.index', $property)
            ->with('success', 'Unità creata correttamente.');
    }

    public function edit(Property $property, Unit $unit, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeUnit($unit, $property);

        return view('landlord.units.edit', compact('property', 'unit'));
    }

    public function update(Property $property, Unit $unit, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeUnit($unit, $property);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'floor' => 'nullable|integer',
            'size_sqm' => 'nullable|numeric',
            'interior' => 'nullable|string|max:255',
            'rooms' => 'nullable|integer',
            'accessory' => 'nullable|string|max:255',
            'status' => 'required|string|in:available,occupied',
            'monthly_rent' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $unit->update($data);

        return redirect()
            ->route('landlord.units.index', $property)
            ->with('success', 'Unità aggiornata correttamente.');
    }

    public function destroy(Property $property, Unit $unit, Request $request)
    {
        $this->authorizeProperty($property, $request);
        $this->authorizeUnit($unit, $property);

        $unit->delete();

        return redirect()
            ->route('landlord.units.index', $property)
            ->with('success', 'Unità eliminata.');
    }

    private function authorizeProperty(Property $property, Request $request)
    {
        $landlord = $request->user()->landlord;

        if (!$property->landlords->contains($landlord->id)) {
            abort(403, 'Non sei autorizzato ad accedere a questa proprietà.');
        }
    }

    private function authorizeUnit(Unit $unit, Property $property)
    {
        if ($unit->property_id !== $property->id) {
            abort(403, 'Questa unità non appartiene a questa proprietà.');
        }
    }
}
