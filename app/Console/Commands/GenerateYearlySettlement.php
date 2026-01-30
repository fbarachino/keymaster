<?php

namespace App\Console\Commands;

use App\Models\Lease;
use App\Models\LeaseTotal;
use App\Models\Expense;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Notifications\YearlySettlementGenerated;
use PDF;

class GenerateYearlySettlement extends Command
{
    protected $signature = 'payments:generate-yearly {year?}';
    protected $description = 'Genera il conguaglio annuale per ogni lease (modello C)';

    public function handle(): int
    {
        $year = $this->argument('year') ?? now()->year;

        $leases = Lease::with('tenants', 'unit.property.landlord')
            ->whereYear('start_date', '<=', $year)
            ->get();

        foreach ($leases as $lease) {

            // Spese dell'anno
            $expenses = Expense::where('lease_id', $lease->id)
                ->whereYear('date', $year)
                ->get();

            $totalTenantExpenses = $expenses->sum('tenant_share');
            $totalLandlordExpenses = $expenses->sum('landlord_share');

            // Totale pagato dai tenants
            $payments = $lease->payments()
                ->whereYear('due_date', $year)
                ->sum('amount_paid');

            // Saldo finale
            $balance = $payments - $totalTenantExpenses;

            // Salva totale annuale
            $total = LeaseTotal::updateOrCreate(
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

            // Genera PDF annuale unico per lease
            $pdf = PDF::loadView('pdf.yearly_settlement', [
                'lease' => $lease,
                'year' => $year,
                'expenses' => $expenses,
                'totalTenantExpenses' => $totalTenantExpenses,
                'totalLandlordExpenses' => $totalLandlordExpenses,
                'payments' => $payments,
                'balance' => $balance,
            ]);

            $pdfContent = $pdf->output();
            $path = "reports/{$year}/conguaglio_lease_{$lease->id}.pdf";
            Storage::disk('public')->put($path, $pdfContent);

            // Notifica al landlord
            $lease->unit->property->landlord->notify(
                new YearlySettlementGenerated($lease, $pdfContent, $year)
            );
        }

        $this->info("Conguaglio annuale generato correttamente per l'anno {$year}.");
        return self::SUCCESS;
    }
}
