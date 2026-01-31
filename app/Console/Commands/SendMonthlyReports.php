<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Lease;
use App\Mail\MonthlyReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMonthlyReports extends Command
{
    protected $signature = 'reports:send-monthly';
    protected $description = 'Invia i report mensili ai tenants per il mese precedente';

    public function handle()
    {
        $this->info('Invio report mensili iniziato...');

        // Mese precedente
        $month = Carbon::now()->subMonth()->month;
        $year  = Carbon::now()->subMonth()->year;

        Log::info("Inviando report mensili per $month/$year");

        // Recupera tutte le leases attive
            $leases = Lease::with([
                'tenants',
                'expenses.documents',
                'property',
                'unit.property' // se la property è legata all’unit
            ])->get();

        //dd($leases->property);
        foreach ($leases as $lease) {

            $expenses = $lease->expenses()
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('tenant_visible', true)
                ->get();

            if ($lease->split_mode === 'equal') {
                $this->sendSplitReports($lease, $expenses);
            } else {
                $this->sendFullReport($lease, $expenses);
            }
        }

        $this->info('Invio report mensili completato.');
    }

    protected function sendSplitReports($lease, $expenses)
    {
        $tenants = $lease->tenants;
        $documents = $expenses->flatMap->documents;

        foreach ($tenants as $tenant) {
            $report = [
                'rent_quota' => $lease->rent_amount / $tenants->count(),
                'expense_quota' => $expenses->sum('amount') / $tenants->count(),
                'documents' => $documents,
                'advance_expenses_quota' => $lease->advance_expenses / $tenants->count(),
            ];

            Mail::to($tenant->email)->send(
                new MonthlyReportMail($report, $lease, $tenant, $documents)
            );
        }
    }

    protected function sendFullReport($lease, $expenses)
    {
        $tenants = $lease->tenants;
        $documents = $expenses->flatMap->documents;

        $report = [
            'rent' => $lease->rent_amount,
            'expenses' => $expenses,
            'documents' => $documents,
            'advance_expenses_quota' => $lease->advance_expenses, // intero
        ];

        foreach ($tenants as $tenant) {
            Mail::to($tenant->email)->send(
                new MonthlyReportMail($report, $lease, $tenant, $documents)
            );
        }
    }
}
