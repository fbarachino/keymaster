<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordUnitController extends Controller
{
    public function show(Request $request, Unit $unit)
    {
        abort_if($unit->property->landlord_id !== $request->user()->id, 403);

        return $unit->load(['property', 'lease.tenant']);
    }
}
