<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function contract3plus2(Lease $lease)
    {
        $landlord = $lease->unit->property->landlord; // adatta al tuo modello
        $tenant   = $lease->tenant;
        $property = $lease->unit->property;
        $unit     = $lease->unit;

        $pdf = Pdf::loadView('contracts.3plus2', [
            'lease'    => $lease,
            'landlord' => $landlord,
            'tenant'   => $tenant,
            'property' => $property,
            'unit'     => $unit,
        ])->setPaper('a4');

        //$fileName = 'Contratto_3+2_'.$tenant->last_name.'_'.$lease->id.'.pdf';
        $tenant = $lease->tenants->first();
        $fileName = 'Contratto_3+2_'.$tenant->last_name.'_'.$lease->id.'.pdf';
        return $pdf->download($fileName);
        // oppure ->stream($fileName);
    }
}
