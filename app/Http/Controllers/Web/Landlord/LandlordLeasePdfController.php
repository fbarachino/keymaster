<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use Barryvdh\DomPDF\Facade\Pdf;

class LandlordLeasePdfController extends Controller
{
    public function show(Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== auth()->id(), 403);

        $lease->load(['tenant', 'unit.property']);

        $pdf = Pdf::loadView('landlord.leases.pdf', compact('lease'));

        return $pdf->download('contratto-'.$lease->id.'.pdf');
    }
}
