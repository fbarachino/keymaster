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
        $tenant = auth()->user()->tenant;
        $payments = Payment::where('tenant_id', $tenant->id)
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

    public function downloadPdf(Payment $payment) {
        $tenant = auth()->user()->tenant;
        abort_unless($payment->tenant_id === $tenant->id, 403);
        $period = $payment->reference; // es: "Affitto 2025-01" → se vuoi puoi parsarlo meglio
        $pdf = PDF::loadView('pdf.monthly_tenant_summary', [
            'tenant' => $tenant,
            'lease' => $payment->lease,
            'period' => $period,
            'payments' => Payment::where('tenant_id', $tenant->id)
                ->where('lease_id', $payment->lease_id)
                ->where('reference', $payment->reference)
                ->get(),
            ]);
        return $pdf->download("riepilogo_mensile_{$tenant->id}_{$payment->id}.pdf");
        }


}
