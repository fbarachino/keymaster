<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordPropertyController extends Controller
{
    public function index(Request $request)
    {
        return Property::where('landlord_id', $request->user()->id)
            ->with('units')
            ->get();
    }

    public function show(Request $request, Property $property)
    {
        abort_if($property->landlord_id !== $request->user()->id, 403);

        return $property->load('units.lease.tenant');
    }
}
