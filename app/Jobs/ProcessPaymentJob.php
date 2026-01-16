<?php

namespace App\Jobs;


use App\Models\Payment;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceivedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;



class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

   /*  public function handle()
    {
        // Ricarica le relazioni necessarie
        $this->payment->load('lease.tenant');
        // Se manca il tenant, logga e interrompi
        if (!$this->payment->lease || !$this->payment->lease->tenant) {
            \Log::error("Payment {$this->payment->id} non ha un tenant associato tramite lease.");
             return;
             }

        // 1) Genera PDF
        $pdf = PDF::loadView('pdf.receipt', [
            'payment' => $this->payment
        ]);

        $path = 'payments/' . $this->payment->id . '.pdf';
        Storage::put($path, $pdf->output());

        // 2) Aggiorna il pagamento con il percorso PDF
        $this->payment->update([
            'pdf_path' => $path
        ]);

        // 3) Invia mail
        Mail::to($this->payment->tenant->email)
            ->send(new PaymentReceivedMail($this->payment));
    } */

    public function handle()
{
    // Ricarica le relazioni necessarie
    $this->payment->load('lease.tenant');

    // Se manca il tenant, logga e interrompi
    if (!$this->payment->lease || !$this->payment->lease->tenant) {
        \Log::error("Payment {$this->payment->id} non ha un tenant associato tramite lease.");
        return;
    }



    $tenantEmail = $this->payment->lease->tenant->email;

    // 1) Genera PDF
    $pdf = PDF::loadView('pdf.payment', [
        'payment' => $this->payment
    ]);

    $path = 'payments/' . $this->payment->id . '.pdf';
    Storage::put($path, $pdf->output());

    $this->payment->update([
        'pdf_path' => $path
    ]);

    // 2) Invia mail
    Mail::to($tenantEmail)
        ->send(new PaymentReceivedMail($this->payment));
}

}
