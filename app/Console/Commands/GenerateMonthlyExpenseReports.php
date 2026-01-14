<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lease;
use App\Notifications\MonthlyExpenseReport;
use PDF;

class GenerateMonthlyExpenseReports extends Command
{
    protected $signature = 'reports:monthly-expenses';
    protected $description = 'Genera e invia i report mensili delle spese ai tenant e landlord';

    public function handle()
    {
        $leases = Lease::with(['tenant', 'unit.property', 'expenses'])
            ->get();

        foreach ($leases as $lease) {

            // Spese del mese corrente
            $expenses = $lease->expenses()
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->get();

            if ($expenses->isEmpty()) {
                continue;
            }

            // Calcoli
            $totalTenant = $expenses->sum('tenant_share');
            $totalLandlord = $expenses->sum('landlord_share');

            // Genera PDF
            $pdf = PDF::loadView('pdf.monthly_expense_report', [
                'lease' => $lease,
                'tenant' => $lease->tenant,
                'expenses' => $expenses,
                'totalTenant' => $totalTenant,
                'totalLandlord' => $totalLandlord,
                'monthyear' => now()->format('F/Y'),
               // 'total_due' => $total_due,
                'month' => now()->format('F Y'),
                'year' => now()->year,
            ]);

            $pdfContent = $pdf->output();

            // Invia email
            $lease->tenant->notify(new MonthlyExpenseReport($lease, $pdfContent));
            $lease->unit->property->landlord->notify(new MonthlyExpenseReport($lease, $pdfContent));
        }

        return Command::SUCCESS;
    }
}
