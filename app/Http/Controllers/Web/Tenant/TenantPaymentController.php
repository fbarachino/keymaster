<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TenantPaymentController extends Controller
{
    public function index() {
        $payments = Payment::whereHas('lease.tenants', function ($q) {
                $q->where('tenant_id', auth()->id());
                }) ->orderBy('due_date', 'desc')
                ->get();

                return view('tenant.payments.index', compact('payments')); }

    public function show(Payment $payment)
    {
        //abort_if($payment->lease->tenant_id !== auth()->id(), 403);
        abort_if($payment->lease->tenants->where('id', auth()->id())->isEmpty(), 403);
        $payment = Payment::with('lease.unit.property')->findOrFail($payment->id);
        return view('tenant.payments.show', compact('payment'));
    }

    public function receipt(Payment $payment)
    {
        abort_if($payment->lease->tenants->where('id', auth()->id())->isEmpty(), 403);
        $payment->load('lease.tenant', 'lease.unit.property');
        $pdf = Pdf::loadView('pdf.receipt', compact('payment'));
        return $pdf->download('ricevuta_' . $payment->id . '.pdf');
    }

}
