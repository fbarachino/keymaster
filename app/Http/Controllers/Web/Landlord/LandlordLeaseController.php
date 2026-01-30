<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LandlordLeaseController extends Controller
{
    public function index(Request $request)
    {
        return Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $request->user()->id)
        )->with(['unit.property', 'tenant'])->get();
    }

    public function show(Request $request, Lease $lease)
    {
        abort_if($lease->unit->property->landlord_id !== $request->user()->id, 403);

        $totals = $lease->totals()
            ->orderBy('period_type')
            ->orderBy('period', 'desc')
            ->get();

        $monthlyTotals = $lease->totals()
            ->where('period_type', 'monthly')
            ->orderBy('period')
            ->get();

        $chartLabels = $monthlyTotals->pluck('period');
        $chartDue = $monthlyTotals->map(fn($t) => $t->rent_total + $t->advance_total);

        $chartPaid = $lease->payments()
            ->selectRaw("SUBSTRING(reference, -7) AS period, SUM(amount_paid) AS total")
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('total', 'period');

        $chartPaid = $chartLabels->map(fn($p) => $chartPaid[$p] ?? 0);


        $yearlyTotals = $lease->totals()
            ->where('period_type', 'yearly')
            ->orderBy('period', 'desc')
            ->get();

        $payments = $lease->payments()
            ->with('tenant')
            ->orderBy('due_date')
            ->get();

        //return view('landlord.leases.show', compact('lease', 'monthlyTotals', 'yearlyTotals'));
        // return $lease->load(['unit.property', 'tenant', 'payments']);
        return view('leases.show', compact(
            'lease',
            'monthlyTotals',
            'chartLabels',
            'chartDue',
            'chartPaid'
    ));

    }

    public function downloadMonthlyPdf(Lease $lease, string $period)
    {
        $path = "reports/{$period}/mensile_lease_{$lease->id}.pdf";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'PDF non trovato.');
        }

        return Storage::disk('public')->download($path);
    }

    public function downloadYearlyPdf(Lease $lease, string $year)
    {
        $path = "reports/{$year}/conguaglio_lease_{$lease->id}.pdf";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'PDF non trovato.');
        }

        return Storage::disk('public')->download($path);
    }


}
