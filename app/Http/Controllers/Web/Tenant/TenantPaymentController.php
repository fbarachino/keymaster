<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantPaymentController extends Controller
{
    /*public function index()
    {
        $payments = Payment::where('tenant_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tenant.payments.index', compact('payments'));
    }*/
        public function index() {
            $payments = Payment::whereHas('lease', function ($q) {
                 $q->where('tenant_id', auth()->id());
                 }) ->orderBy('due_date', 'desc')
                 ->get();
                 return view('tenant.payments.index', compact('payments')); }

    public function show(Payment $payment)
    {
        abort_if($payment->lease->tenant_id !== auth()->id(), 403);

        return view('tenant.payments.show', compact('payment'));
    }


}
