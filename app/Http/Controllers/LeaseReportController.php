<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Mail\MonthlyReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LeaseReportController extends Controller
{
    public function monthlyReport(Lease $lease)
    {
        $tenants = $lease->tenants;
        $expenses = $lease->expenses()->where('tenant_visible', true)->get();

        if ($lease->isSplitModeEqual()) {
            return $this->generateSplitReports($lease, $tenants, $expenses);
        }

        return $this->generateFullReport($lease, $tenants, $expenses);
    }

    protected function sendSplitReports($lease, $expenses)
{
    $tenants = $lease->tenants;
    $documents = $expenses->flatMap->documents;

    foreach ($tenants as $tenant) {
        $report = [
            'rent_quota' => $lease->rent_amount / $tenants->count(),
            'expense_quota' => $expenses->sum('amount') / $tenants->count(),
            'advance_expenses_quota' => $lease->advance_expenses / $tenants->count(),
            'documents' => $documents,
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
        'advance_expenses_quota' => $lease->advance_expenses, // intero
        'documents' => $documents,
    ];

    foreach ($tenants as $tenant) {
        Mail::to($tenant->email)->send(
            new MonthlyReportMail($report, $lease, $tenant, $documents)
        );
    }
}

}
