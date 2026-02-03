<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Lease;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user()->tenant;

        // Lease attiva
        $lease = $tenant->leases()->where('status', 'active')->first();

        // KPI
        $totalPaid = Payment::where('tenant_id', $tenant->id)
            ->where('status', 'paid')
            ->sum('amount_total');

        $totalDue = Payment::where('tenant_id', $tenant->id)
            ->where('status', 'pending')
            ->sum('amount_total');

        $latePaymentsCount = Payment::where('tenant_id', $tenant->id)
            ->where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->count();

        $nextPayment = Payment::where('tenant_id', $tenant->id)
            ->where('status', 'pending')
            ->orderBy('due_date')
            ->first();

        // Grafico pagamenti ultimi 12 mesi
        $months = collect();
        $paymentsPerMonth = collect();

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $label = $month->format('m/Y');
            $months->push($label);

            $sum = Payment::where('tenant_id', $tenant->id)
                ->where('status', 'paid')
                ->whereBetween('due_date', [
                    $month->copy()->startOfMonth(),
                    $month->copy()->endOfMonth()
                ])
                ->sum('amount_total');

            $paymentsPerMonth->push($sum);
        }

        // Ripartizione spese
        $expenseCategories = ['Condominio', 'Acqua', 'Luce', 'Gas', 'Altro'];
        $expenseData = [];

        foreach ($expenseCategories as $cat) {
            $expenseData[] = $tenant->expenses()
                ->where('category', $cat)
                ->sum('amount');
        }

        // Timeline pagamenti
        $timelinePayments = Payment::where('tenant_id', $tenant->id)
            ->orderBy('due_date')
            ->limit(20)
            ->get();

        return view('tenant.dashboard.index', compact(
            'tenant',
            'lease',
            'totalPaid',
            'totalDue',
            'latePaymentsCount',
            'nextPayment',
            'months',
            'paymentsPerMonth',
            'expenseCategories',
            'expenseData',
            'timelinePayments'
        ));
    }
}
