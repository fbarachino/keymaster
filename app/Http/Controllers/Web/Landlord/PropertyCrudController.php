<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyCrudController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::where('landlord_id', $request->user()->id)->get();
        return view('landlord.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('landlord.properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ]);

        $data['landlord_id'] = $request->user()->id;

        Property::create($data);

        return redirect()->route('landlord.properties.index');
    }

    public function edit(Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);
        return view('landlord.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => 'nullable',
        ]);

        $property->update($data);

        return redirect()->route('landlord.properties.index');
    }

    public function destroy(Property $property)
    {
        abort_if($property->landlord_id !== auth()->id(), 403);

        $property->delete();
        return redirect()->route('landlord.properties.index');
    }
}
