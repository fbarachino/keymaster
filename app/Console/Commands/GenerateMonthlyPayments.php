<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\Payment;
use Barryvdh\DomPDF\PDF;
use App\Models\LeaseTotal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PaymentRegistered;
use App\Notifications\MonthlyLeaseSummaryGenerated;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'payments:generate-monthly';
    protected $description = 'Genera i pagamenti mensili per ogni lease attiva (modello ibrido)';

    public function handle(): int
    {
        $today = now();
        $period = $today->format('Y-m'); // es: 2025-01
        $dueDate = $today->copy()->startOfMonth()->addDays(4); // 5 del mese

        $leases = Lease::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->with('tenants')
            ->get();

        if ($leases->isEmpty()) {
            $this->info('Nessuna lease attiva trovata.');
            return self::SUCCESS;
        }



        foreach ($leases as $lease) {

            $tenants = $lease->tenants;
            $tenantCount = max(1, $tenants->count());

            // Totali lease (livello contabile)
            $rentTotal = $lease->rent_amount;
            $advanceTotal = $lease->advance_expenses;

            // Crea record contabile mensile
            LeaseTotal::updateOrCreate(
                [
                    'lease_id' => $lease->id,
                    'period' => $period,
                    'period_type' => 'monthly',
                ],
                [
                    'rent_total' => $rentTotal,
                    'advance_total' => $advanceTotal,
                ]
            );

                    // Genera PDF mensile unico per lease
            $pdf = app('dompdf.wrapper')->loadView('pdf.monthly_lease_summary', [
                'lease' => $lease,
                'total' => LeaseTotal::where('lease_id', $lease->id)
                    ->where('period', $period)
                    ->where('period_type', 'monthly')
                    ->first(),
                'period' => $period,
            ]);

            $pdfContent = $pdf->output();

            // Salvataggio PDF
            $path = "reports/{$period}/mensile_lease_{$lease->id}.pdf";
            Storage::disk('public')->put($path, $pdfContent);

            $lease->unit->property->landlord->notify( new MonthlyLeaseSummaryGenerated($lease, $pdfContent, $period) );

            // Pagamenti individuali
            // ----------------------

            // AFFITTO
            if ($rentTotal > 0) {

                $quota = $rentTotal / $tenantCount;

                foreach ($tenants as $tenant) {

                    $payment = Payment::create([
                        'lease_id'   => $lease->id,
                        'tenant_id'  => $tenant->id,
                        'type'       => 'rent',
                        'amount_due' => $quota,
                        'due_date'   => $dueDate,
                        'status'     => 'pending',
                        'reference'  => "Affitto {$period}",
                    ]);

                    $tenant->notify(new PaymentRegistered($payment));
                }
            }

            // ANTICIPO SPESE
            if ($advanceTotal > 0) {

                $quota = $advanceTotal / $tenantCount;

                foreach ($tenants as $tenant) {

                    $payment = Payment::create([
                        'lease_id'   => $lease->id,
                        'tenant_id'  => $tenant->id,
                        'type'       => 'advance_expenses',
                        'amount_due' => $quota,
                        'due_date'   => $dueDate,
                        'status'     => 'pending',
                        'reference'  => "Anticipo spese {$period}",
                    ]);

                    $tenant->notify(new PaymentRegistered($payment));
                }
            }
            // Genera PDF individuale per tenant
            $pdf = app('dompdf.wrapper')->loadView('pdf.monthly_tenant_summary', [
            'tenant' => $tenant,
            'lease' => $lease,
            'period' => $period,
            'payments' => Payment::where('tenant_id', $tenant->id)
                ->where('lease_id', $lease->id)
                ->where('reference', 'like', "%{$period}%")
                ->get(),
        ]);

        $pdfContent = $pdf->output();

        // Salvataggio PDF
        $path = "reports/{$period}/mensile_tenant_{$tenant->id}_{$lease->id}.pdf";
        Storage::disk('public')->put($path, $pdfContent);

        }

        $this->info('Pagamenti mensili generati con successo (modello ibrido).');

        return self::SUCCESS;
    }
}
