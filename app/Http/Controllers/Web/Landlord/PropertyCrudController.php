<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyCrudController extends Controller
{
    /**
     * Lista delle proprietà del landlord loggato.
     */
    public function index(Request $request)
    {
        $landlord = $request->user()->landlord;

        $properties = Property::whereHas('landlords', function ($q) use ($landlord) {
                $q->where('landlords.id', $landlord->id);
            })
            ->orderBy('name')
            ->paginate(10);

        return view('landlord.properties.index', compact('properties'));
    }

    /**
     * Form creazione property.
     */
    public function create()
    {
        return view('landlord.properties.create');
    }

    /**
     * Salvataggio property + associazione landlord.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'purchase_price' => 'nullable|numeric',

            'address' => 'required|string|max:255',
            'zip' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',

            'cadastral_sheet' => 'nullable|string',
            'cadastral_particle' => 'nullable|string',
            'cadastral_sub' => 'nullable|string',
            'cadastral_category' => 'nullable|string',
            'cadastral_class' => 'nullable|string',
            'cadastral_rent' => 'nullable|numeric',
        ]);

        // 1. Creazione property
        $property = Property::create($data);

        // 2. Associazione landlord → property
        $landlord = $request->user()->landlord;

        $property->landlords()->attach($landlord->id, [
            'ownership_percentage' => 100,
        ]);

        return redirect()
            ->route('landlord.properties.index')
            ->with('success', 'Proprietà creata correttamente.');
    }

    /**
     * Form modifica property.
     */
    public function edit(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        return view('landlord.properties.edit', compact('property'));
    }

    /**
     * Aggiornamento property.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorizeProperty($property, $request);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'purchase_price' => 'nullable|numeric',

            'address' => 'required|string|max:255',
            'zip' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',

            'cadastral_sheet' => 'nullable|string',
            'cadastral_particle' => 'nullable|string',
            'cadastral_sub' => 'nullable|string',
            'cadastral_category' => 'nullable|string',
            'cadastral_class' => 'nullable|string',
            'cadastral_rent' => 'nullable|numeric',
        ]);

        $property->update($data);

        return redirect()
            ->route('landlord.properties.index')
            ->with('success', 'Proprietà aggiornata correttamente.');
    }

    /**
     * Eliminazione property.
     */
    public function destroy(Property $property, Request $request)
    {
        $this->authorizeProperty($property, $request);

        $property->delete();

        return redirect()
            ->route('landlord.properties.index')
            ->with('success', 'Proprietà eliminata.');
    }

    /**
     * Verifica che la property appartenga al landlord loggato.
     */
    private function authorizeProperty(Property $property, Request $request)
    {
        $landlord = $request->user()->landlord;

        if (!$property->landlords->contains($landlord->id)) {
            abort(403, 'Non sei autorizzato ad accedere a questa proprietà.');
        }
    }
}
