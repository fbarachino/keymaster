<?php
// app/Console/Commands/GenerateMonthlyPayments.php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Console\Command;
use App\Notifications\PaymentRegistered;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'payments:generate-monthly';
    protected $description = 'Genera i pagamenti mensili di affitto e anticipo spese per tutte le lease attive';

    public function handle(): int
    {
        $today = now();

        $leases = Lease::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        if ($leases->isEmpty()) {
            $this->info('Nessuna lease attiva trovata.');
            return self::SUCCESS;
        }

        $dueDate = $today->copy()->startOfMonth()->addDays(4); // 5 del mese
        $monthLabel = $today->format('m/Y');

        foreach ($leases as $lease) {

            // AFFITTO
            if ($lease->rent_amount > 0) {
                $payment =Payment::create([
                    'lease_id'  => $lease->id,
                    'amount'    => $lease->rent_amount,
                    'due_date'  => $dueDate,
                    'reference' => "Affitto {$monthLabel}",
                    'status'    => 'pending',
                    'type'      => 'rent',
                ]);
                foreach($lease->tenants as $tenant) {
                    $tenant->notify(new PaymentRegistered($payment));
                }
            }


            // ANTICIPO SPESE
            if ($lease->advance_expenses > 0) {
                $payment=Payment::create([
                    'lease_id'  => $lease->id,
                    'amount'    => $lease->advance_expenses,
                    'due_date'  => $dueDate,
                    'reference' => "Anticipo spese {$monthLabel}",
                    'status'    => 'pending',
                    'type'      => 'advance-expenses',
                ]);
                foreach($lease->tenants as $tenant) {
                    $tenant->notify(new PaymentRegistered($payment));
                }
            }
        }

        $this->info('Pagamenti mensili generati con successo.');

        return self::SUCCESS;
    }
}
