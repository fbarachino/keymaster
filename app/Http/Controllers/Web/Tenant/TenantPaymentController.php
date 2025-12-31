<?php

namespace App\Http\Controllers\Portal\Tenant;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantPaymentController extends Controller
{
    public function index(Request $request)
    {
        return Payment::whereHas('lease', fn($q) =>
            $q->where('tenant_id', $request->user()->id)
        )->get();
    }

    public function show(Request $request, Payment $payment)
    {
        abort_if($payment->lease->tenant_id !== $request->user()->id, 403);

        return $payment->load('lease.unit.property');
    }
}
