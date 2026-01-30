<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Payment;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenantPaymentController extends Controller
{

    public function index() {
        $payments = Payment::where('tenant_id', auth()->user()->tenant->id)
        ->orderBy('due_date')
        ->get();

    return view('tenant.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {

        abort_if($payment->lease->tenant_id !== auth()->id(), 403);


        return view('tenant.payments.show', compact('payment'));
    }

    public function receipt(Payment $payment)
    {
        abort_if($payment->lease->tenant_id !== auth()->id(), 403);

        $payment->load('lease.tenant', 'lease.unit.property');

        $pdf = PDF::loadView('pdf.receipt', compact('payment'));

        return $pdf->download('ricevuta_' . $payment->id . '.pdf');
    }

}
