<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class TenantPaymentController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user()->tenant;

        $payments = Payment::where('tenant_id', $tenant->id)
            ->orderBy('due_date')
            ->paginate(20);

        return view('tenant.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        abort_unless($payment->tenant_id === auth()->user()->tenant->id, 403);

        return view('tenant.payments.show', compact('payment'));
    }
}
