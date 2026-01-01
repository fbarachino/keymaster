<?php

namespace App\Http\Controllers\Web\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaseSignatureController extends Controller
{
    /**
     * Show the lease signature form.
     */
    public function showForm(Lease $lease)
    {
        abort_if($lease->tenant_id !== auth()->id(), 403);

        return view('tenant.leases.sign', compact('lease'));
    }

    /**
     * Handle the lease signing.
     */
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
}
