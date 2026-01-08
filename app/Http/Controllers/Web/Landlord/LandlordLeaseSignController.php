<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class LandlordLeaseController extends Controller
{
    public function sign(Request $request, Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== auth()->id(), 403);

        $lease->update([
            'signed_by_landlord_at' => now(),
        ]);

        $lease->refresh();
    // INVIO EMAIL AL TENANT
    Mail::to($lease->tenant->email)
        ->send(new \App\Mail\LeaseSignedByLandlord($lease));

    return back()->with('success', 'Hai firmato il contratto.');
}
}
