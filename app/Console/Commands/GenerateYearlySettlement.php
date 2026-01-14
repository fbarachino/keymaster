<?php

namespace App\Console\Commands;

use PDF;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\YearlyReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Notifications\YearlySettlementReport;

class GenerateYearlySettlement extends Command
{
    protected $signature = 'reports:yearly-settlement {year?}';
    protected $description = 'Genera il conguaglio annuale delle spese per ogni lease';

    public function handle()
    {
        $year = $this->argument('year') ?? now()->subYear()->year;

        $leases = Lease::with(['tenant', 'unit.property'])
            ->get();

        foreach ($leases as $lease) {

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

            // Pagamenti del tenant nell'anno
            /*$payments = Payment::where('lease_id', $lease->id)
                ->whereYear('paid_date', $year)
                ->where('status', 'paid')
                ->sum('amount');*/
            $payments = Payment::where('lease_id', $lease->id)
                ->where('type', 'expense')
                ->whereYear('paid_date', $year)
                ->where('status', 'paid')
                ->sum('amount');

            // Saldo finale
            $balance = $totalTenantExpenses - $payments;

            // Genera PDF
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

                        // Salvataggio del PDF per archivio
            $path = "reports/{$year}/conguaglio_lease_{$lease->id}.pdf";
            Storage::disk('public')->put($path, $pdfContent);

            // Salva nel database (se usi la tabella yearly_reports)
            YearlyReport::create([
                'lease_id' => $lease->id,
                'year' => $year,
                'file_path' => $path,
            ]);

            // Invia email
            $lease->tenant->notify(new YearlySettlementReport($lease, $pdfContent, $year));
            $lease->unit->property->landlord->notify(new YearlySettlementReport($lease, $pdfContent, $year));
        }

        return Command::SUCCESS;
    }
}
