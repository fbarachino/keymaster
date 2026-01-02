<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Lease;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class LeasePdfController extends Controller
{
    // Download lease PDF for tenant or landlord

    public function downloadPdf(Lease $lease)
    {
        abort_if($lease->tenant_id !== auth()->id() &&
                $lease->unit->property->landlord_id !== auth()->id(), 403);

        $pdf = Pdf::loadView('pdf.lease', compact('lease'));

        return $pdf->download('contratto-'.$lease->id.'.pdf');
    }

}
