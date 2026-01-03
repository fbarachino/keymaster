<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Lease;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class TenantLeaseController extends Controller
{
    public function index(Request $request)
    {
        $leases = Lease::where('tenant_id', $request->user()->id)
            ->with(['unit.property'])
            ->get();

        return view('tenant.leases.index', compact('leases'));
    }

    public function show(Request $request, Lease $lease)
    {
        abort_if($lease->tenant_id !== $request->user()->id, 403);

        return $lease->load(['unit.property', 'payments']);
    }

    public function sign(Request $request, Lease $lease)
    {
        abort_if($lease->tenant_id !== auth()->id(), 403);

        $request->validate(['signature' => 'required']);

        $image = str_replace('data:image/png;base64,', '', $request->signature);
        $image = base64_decode($image);

        $path = 'signatures/' . uniqid() . '.png';
        Storage::disk('public')->put($path, $image);

        $lease->update([
            'signature_path' => $path,
            'signed_at' => now(),
        ]);

        return redirect()->route('tenant.leases.index')
            ->with('success', 'Contratto firmato con successo.');
    }



    public function downloadPdf(Lease $lease)
    {
        abort_if($lease->tenant_id !== auth()->id() &&
                $lease->unit->property->landlord_id !== auth()->id(), 403);

        $pdf = Pdf::loadView('pdf.lease', compact('lease'));

        return $pdf->download('contratto-'.$lease->id.'.pdf');
    }


}
