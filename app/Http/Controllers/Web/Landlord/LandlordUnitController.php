<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class LandlordUnitController extends Controller
{
    public function available(Request $request)
    {
        $landlord = $request->user()->landlord;

        $units = Unit::where('status', 'available')
            ->whereHas('property.landlords', fn($q) => $q->whereKey($landlord->id))
            ->get();

        return view('landlord.units.available', compact('units'));
    }
}
