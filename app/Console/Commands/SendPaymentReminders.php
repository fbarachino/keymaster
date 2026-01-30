<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;
use App\Notifications\PaymentReminder;

class SendPaymentReminders extends Command
{
    protected $signature = 'payments:send-reminders';
    protected $description = 'Invia promemoria per pagamenti in scadenza o scaduti';

    public function handle(): int
    {
        $today = now();

        // Pagamenti in scadenza tra 3 giorni
        $upcoming = Payment::where('status', 'pending')
            ->whereDate('due_date', $today->copy()->addDays(3))
            ->get();

        foreach ($upcoming as $payment) {
            $payment->tenant->notify(new PaymentReminder($payment, 'upcoming'));
        }

        // Pagamenti scaduti da 1 giorno
        $overdue = Payment::where('status', 'pending')
            ->whereDate('due_date', $today->copy()->subDay())
            ->get();

        foreach ($overdue as $payment) {
            $payment->update(['status' => 'overdue']);
            $payment->tenant->notify(new PaymentReminder($payment, 'overdue'));
        }

        $this->info("Promemoria inviati correttamente.");
        return self::SUCCESS;
    }
}
