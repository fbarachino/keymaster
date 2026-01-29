<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TenantLeaseSignController extends Controller
{
    public function show(Lease $lease)
    {
        abort_if(!$lease->tenants->pluck('id')->contains(auth()->id()), 403);


        return view('tenant.leases.sign', compact('lease'));
    }

    public function sign(Request $request, Lease $lease)
    {
        abort_if(!$lease->tenants->pluck('id')->contains(auth()->id()), 403);
        $timestamp = now()->format('Y-m-d H:i:s');
        $request->validate([
            'accept' => 'accepted',
        ]);

        $lease->update([
            'signed_by_tenant_at' => $timestamp,
        ]);

        $lease->refresh();

        //dd($lease);
        // INVIO EMAIL AL LANDLORD
        Mail::to($lease->unit->property->landlord->email)
            ->send(new \App\Mail\LeaseSignedByTenant($lease));

        return redirect()->route('tenant.leases.index')
            ->with('success', 'Contratto firmato digitalmente.');
    }

}
