<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\Payment;
use App\Models\LeaseTotal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PaymentRegistered;
use App\Notifications\MonthlyLeaseSummaryGenerated;
use PDF;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'payments:generate-monthly';
    protected $description = 'Genera i pagamenti mensili per ogni lease attiva (modello C)';

    public function handle(): int
    {
        $today = now();
        $period = $today->format('Y-m');
        $dueDate = $today->copy()->startOfMonth()->addDays(4);

        $leases = Lease::with('tenants', 'unit.property.landlord')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        foreach ($leases as $lease) {

            $tenants = $lease->tenants;
            $tenantCount = max(1, $tenants->count());

            // Totali lease
            $rentTotal = $lease->rent_amount;
            $advanceTotal = $lease->advance_expenses;

            // Salva totale mensile
            $total = LeaseTotal::updateOrCreate(
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

            // Pagamenti individuali
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

                    // PDF individuale
                    $pdf = PDF::loadView('pdf.monthly_tenant_summary', [
                        'tenant' => $tenant,
                        'lease' => $lease,
                        'period' => $period,
                        'payments' => Payment::where('tenant_id', $tenant->id)
                            ->where('lease_id', $lease->id)
                            ->where('reference', "Affitto {$period}")
                            ->get(),
                    ]);

                    $pdfContent = $pdf->output();
                    $path = "reports/{$period}/mensile_tenant_{$tenant->id}_{$lease->id}.pdf";
                    Storage::disk('public')->put($path, $pdfContent);

                    // Notifica individuale
                    $tenant->notify(new PaymentRegistered($payment, $pdfContent, $period));
                }
            }

            // Anticipo spese
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

                    // PDF individuale
                    $pdf = PDF::loadView('pdf.monthly_tenant_summary', [
                        'tenant' => $tenant,
                        'lease' => $lease,
                        'period' => $period,
                        'payments' => Payment::where('tenant_id', $tenant->id)
                            ->where('lease_id', $lease->id)
                            ->where('reference', "Anticipo spese {$period}")
                            ->get(),
                    ]);

                    $pdfContent = $pdf->output();
                    $path = "reports/{$period}/mensile_tenant_{$tenant->id}_{$lease->id}.pdf";
                    Storage::disk('public')->put($path, $pdfContent);

                    // Notifica individuale
                    $tenant->notify(new PaymentRegistered($payment, $pdfContent, $period));
                }
            }

            // PDF mensile unico per lease
            $pdfLease = PDF::loadView('pdf.monthly_lease_summary', [
                'lease' => $lease,
                'total' => $total,
                'period' => $period,
            ]);

            $pdfLeaseContent = $pdfLease->output();
            $leasePath = "reports/{$period}/mensile_lease_{$lease->id}.pdf";
            Storage::disk('public')->put($leasePath, $pdfLeaseContent);

            // Notifica al landlord
            $lease->unit->property->landlord->notify(
                new MonthlyLeaseSummaryGenerated($lease, $pdfLeaseContent, $period)
            );
        }

        $this->info("Pagamenti mensili generati correttamente per il periodo {$period}.");
        return self::SUCCESS;
    }
}
