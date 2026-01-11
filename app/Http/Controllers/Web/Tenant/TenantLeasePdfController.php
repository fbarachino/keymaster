<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TenantLeasePdfController extends Controller
{
    public function show(Request $request, Lease $lease)
    {
        // Sicurezza: il tenant può scaricare solo i suoi contratti
        abort_if($lease->tenant_id !== $request->user()->id, 403);

        $lease->load(['tenant', 'unit.property']);

        $pdf = Pdf::loadView('landlord.leases.pdf', compact('lease'));

        return $pdf->download('contratto-'.$lease->id.'.pdf');
    }
}
