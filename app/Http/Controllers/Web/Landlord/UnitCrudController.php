<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UnitCrudController extends Controller
{
    public function index(Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);

        return view('landlord.units.index', [
            'property' => $property,
            'units' => $property->units
        ]);
    }

    public function create(Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);

        return view('landlord.units.create', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required',
            'floor' => 'nullable|integer',
            'size' => 'nullable|integer',
            'monthly_rent' => 'required|numeric',
            'status' => 'required|in:available,occupied',
        ]);

        $data['property_id'] = $property->id;

        Unit::create($data);

        return redirect()->route('landlord.units.index', $property)
            ->with('success', 'Unità creata con successo.');
    }

    public function edit(Property $property, Unit $unit)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        abort_if($unit->property_id !== $property->id, 403);
        $qr = base64_encode(
            QrCode::format('png')->size(200)->generate(url('/unit/' . $unit->id))
        );


        return view('landlord.units.edit', compact('property', 'unit', 'qr'));
    }

    public function update(Request $request, Property $property, Unit $unit)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        abort_if($unit->property_id !== $property->id, 403);

        $data = $request->validate([
            'name' => 'required',
            'floor' => 'nullable|integer',
            'size' => 'nullable|integer',
            'monthly_rent' => 'required|numeric',
            'status' => 'required|in:available,occupied',
        ]);

        $unit->update($data);

        return redirect()->route('landlord.units.index', $property)
            ->with('success', 'Unità aggiornata con successo.');
    }

    public function destroy(Property $property, Unit $unit)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        abort_if($unit->property_id !== $property->id, 403);

        $unit->delete();

        return redirect()->route('landlord.units.index', $property)
            ->with('success', 'Unità eliminata.');
    }



    public function uploadDocument(Request $request, Property $property, Unit $unit)
    {
        abort_if($unit->property_id !== $property->id, 403);

        $data = $request->validate([
            'name' => 'required',
            'document' => 'required|file|max:10240', // 10MB
        ]);

        $path = $request->file('document')->store('unit_documents', 'public');

        $unit->documents()->create([
            'name' => $data['name'],
            'path' => $path,
        ]);

        return back()->with('success', 'Documento caricato.');
    }

    public function addInventory(Request $request, Property $property, Unit $unit)
    {
        abort_if($unit->property_id !== $property->id, 403);

        $data = $request->validate([
            'item' => 'required',
            'condition' => 'required|in:good,worn,damaged',
            'notes' => 'nullable',
        ]);

        $unit->inventory()->create($data);

        return back()->with('success', 'Elemento aggiunto all’inventario.');
    }

    public function uploadPhotos(Request $request, Property $property, Unit $unit)
    {
        abort_if($unit->property_id !== $property->id, 403);

        $request->validate([
            'photos.*' => 'required|image|max:4096',
        ]);

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('units', 'public');
            $unit->photos()->create(['path' => $path]);
        }

        return back()->with('success', 'Foto caricate con successo.');
    }


}
