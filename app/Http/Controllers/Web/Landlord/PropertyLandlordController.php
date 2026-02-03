<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Property;
use App\Models\Landlord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyLandlordController extends Controller
{
    public function attach(Request $request, Property $property)
    {
        $property->landlords()->attach($request->landlord_id, [
            'ownership_percentage' => $request->ownership_percentage ?? 100,
        ]);

        return back()->with('success', 'Landlord associato correttamente.');
    }

    public function detach(Property $property, Landlord $landlord)
    {
        $property->landlords()->detach($landlord->id);

        return back()->with('success', 'Landlord rimosso dalla property.');
    }
}
