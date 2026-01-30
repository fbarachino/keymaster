<?php

namespace App\Console\Commands;

use PDF;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\LeaseTotal;
use App\Models\YearlyReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Notifications\YearlySettlementReport;
use App\Notifications\YearlySettlementGenerated;

class GenerateYearlySettlement extends Command
{
    protected $signature = 'reports:yearly-settlement {year?}';
    protected $description = 'Genera il conguaglio annuale delle spese per ogni lease (modello ibrido)';

    public function handle()
    {
        $year = $this->argument('year') ?? now()->subYear()->year;

        $leases = Lease::with(['tenants', 'unit.property'])->get();

        foreach ($leases as $lease) {

            $tenants = $lease->tenants;
            $tenantCount = max(1, $tenants->count());

            // Spese dell'anno
            $expenses = $lease->expenses()
                ->whereYear('date', $year)
                ->get();

            if ($expenses->isEmpty()) {
                continue;
            }

            // Totali spese
            $totalTenantExpenses = $expenses->sum('tenant_share');
            $totalLandlordExpenses = $expenses->sum('landlord_share');

            // Pagamenti dei tenants nell'anno
            $payments = Payment::where('lease_id', $lease->id)
                ->where('type', 'expense')
                ->whereYear('paid_at', $year)
                ->where('status', 'paid')
                ->sum('amount_paid');

            // Saldo finale
            $balance = $totalTenantExpenses - $payments;

            // Salva totale annuale (livello contabile)
            LeaseTotal::updateOrCreate(
                [
                    'lease_id' => $lease->id,
                    'period' => $year,
                    'period_type' => 'yearly',
                ],
                [
                    'expenses_total' => $totalTenantExpenses,
                    'settlement_total' => $balance,
                ]
            );

            // Genera PDF unico per la lease
            $pdf = PDF::loadView('pdf.yearly_settlement', [
                'lease' => $lease,
                'expenses' => $expenses,
                'totalTenantExpenses' => $totalTenantExpenses,
                'totalLandlordExpenses' => $totalLandlordExpenses,
                'payments' => $payments,
                'balance' => $balance,
                'year' => $year,
            ]);

            $pdfContent = $pdf->output();

            // Salvataggio PDF
            $path = "reports/{$year}/conguaglio_lease_{$lease->id}.pdf";
            Storage::disk('public')->put($path, $pdfContent);

            // Salva nel database
            YearlyReport::create([
                'lease_id' => $lease->id,
                'year' => $year,
                'file_path' => $path,
            ]);

            // Notifica a tutti i tenants
            foreach ($tenants as $tenant) {
                $tenant->notify(new YearlySettlementReport($lease, $pdfContent, $year));
            }

            // Notifica al landlord
            $lease->unit->property->landlord->notify(
                new YearlySettlementReport($lease, $pdfContent, $year)
            );

            // Se il tenant deve ancora soldi (saldo negativo)
            if ($balance < 0) {

                $amountDue = abs($balance);
                $quota = $amountDue / $tenantCount;

                $dueDate = now()->addMonth()->startOfMonth()->addDays(27);

                foreach ($tenants as $tenant) {

                    $payment = Payment::create([
                        'lease_id'   => $lease->id,
                        'tenant_id'  => $tenant->id,
                        'type'       => 'expense_settlement',
                        'amount_due' => $quota,
                        'due_date'   => $dueDate,
                        'status'     => 'pending',
                        'reference'  => "Conguaglio spese {$year}",
                    ]);

                    $tenant->notify(new YearlySettlementGenerated($quota, $year, $dueDate));
                }
            }

            $this->info("Conguaglio annuale generato per il lease ID {$lease->id} per l'anno {$year}.");
        }

        return Command::SUCCESS;
    }
}
