<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Services\NotificationService;

class CheckLatePayments extends Command
{
    protected $signature = 'payments:check-late';
    protected $description = 'Genera notifiche per pagamenti in ritardo';

    public function handle()
    {
        $latePayments = Payment::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->get();

        foreach ($latePayments as $payment) {

            // Notifica tenant
            NotificationService::notify(
                $payment->tenant->user,
                'payment_late',
                'Pagamento in ritardo',
                "Il pagamento di {$payment->amount_total} € è in ritardo.",
                route('tenant.payments.show', $payment->id)
            );

            // Notifica landlord
            foreach ($payment->lease->property->landlords as $landlord) {
                NotificationService::notify(
                    $landlord->user,
                    'payment_late',
                    'Pagamento in ritardo da un inquilino',
                    "Un pagamento di {$payment->amount_total} € risulta in ritardo.",
                    route('landlord.payments.show', $payment->id)
                );
            }
        }

        $this->info('Notifiche pagamenti in ritardo generate.');
    }
}
