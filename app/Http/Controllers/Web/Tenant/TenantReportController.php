<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TenantReportController extends Controller
{
    public function monthly(Request $request)
    {
        $tenant = $request->user()->tenant;

        $month = $request->input('month', now()->format('Y-m'));
        [$year, $m] = explode('-', $month);

        $payments = Payment::where('tenant_id', $tenant->id)
            ->whereYear('due_date', $year)
            ->whereMonth('due_date', $m)
            ->get();

        $pdf = Pdf::loadView('tenant.reports.monthly', compact('tenant', 'payments', 'month'));

        return $pdf->download("report-mensile-$month.pdf");
    }
    public function yearly(Request $request)
    {
        $tenant = $request->user()->tenant;

        $year = $request->input('year', now()->year);

        $payments = Payment::where('tenant_id', $tenant->id)
            ->whereYear('due_date', $year)
            ->get();

        $pdf = Pdf::loadView('tenant.reports.yearly', compact('tenant', 'payments', 'year'));

        return $pdf->download("report-annuale-$year.pdf");
    }

}
