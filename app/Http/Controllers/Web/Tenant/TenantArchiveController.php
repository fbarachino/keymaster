<?php

namespace App\Http\Controllers\Web\Tenant;
use App\Http\Controllers\Controller;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Support\Facades\Storage;

class TenantArchiveController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;

        // Periodi mensili disponibili
        $monthlyPeriods = Payment::where('tenant_id', $tenant->id)
            ->selectRaw("DISTINCT SUBSTRING(reference, -7) AS period")
            ->orderBy('period', 'desc')
            ->pluck('period');

        // Periodi annuali disponibili
        $lease = $tenant->leases->first(); // tenant può avere più lease? Se sì, si adatta
        $yearlyPeriods = $lease
            ? $lease->totals()->where('period_type', 'yearly')->pluck('period')
            : collect([]);

        return view('tenant.archive.index', compact('monthlyPeriods', 'yearlyPeriods'));
    }

    public function downloadMonthly(string $period)
    {
        $tenant = auth()->user()->tenant;

        $path = "reports/{$period}/mensile_tenant_{$tenant->id}_{$tenant->lease_id}.pdf";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'PDF non trovato.');
        }

        return Storage::disk('public')->download($path);
    }

    public function downloadYearly(string $year)
    {
        $tenant = auth()->user()->tenant;
        $lease = $tenant->leases->first();

        $path = "reports/{$year}/conguaglio_lease_{$lease->id}.pdf";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'PDF non trovato.');
        }

        return Storage::disk('public')->download($path);
    }
}
