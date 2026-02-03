<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Property;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandlordDashboardController extends Controller
{
    public function index(Request $request)
    {
        $landlord = $request->user()->landlord;

        // Filtri
        $propertyId   = $request->property_id;
        $monthFilter  = $request->month;
        $leaseStatus  = $request->lease_status;
        $unitStatus   = $request->unit_status;

        // Range mese
        if ($monthFilter) {
            $month = Carbon::parse($monthFilter);
            $start = $month->copy()->startOfMonth();
            $end   = $month->copy()->endOfMonth();
        } else {
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::now()->endOfMonth();
        }

        // Query base property
        $propertyFilter = function ($q) use ($landlord, $propertyId) {
            $q->whereHas('landlords', fn($l) => $l->whereKey($landlord->id));

            if ($propertyId) {
                $q->where('id', $propertyId);
            }
        };
        // ALERT: Pagamenti in ritardo
        $latePayments = Payment::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->whereHas('lease.property.landlords', fn($q) => $q->whereKey($landlord->id))
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        // ALERT: Lease in scadenza (entro 60 giorni)
        $expiringLeases = Lease::where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(60)])
            ->whereHas('property.landlords', fn($q) => $q->whereKey($landlord->id))
            ->orderBy('end_date')
            ->limit(5)
            ->get();

        // ALERT: Unità disponibili
        $availableUnits = Unit::where('status', 'available')
            ->whereHas('property.landlords', fn($q) => $q->whereKey($landlord->id))
            ->orderBy('name')
            ->limit(5)
            ->get();

        // ALERT: Spese anomale (sopra soglia)
        $expenseThreshold = 500; // puoi renderlo configurabile
        $highExpenses = Expense::where('amount_total', '>', $expenseThreshold)
            ->whereHas('lease.property.landlords', fn($q) => $q->whereKey($landlord->id))
            ->orderByDesc('amount_total')
            ->limit(5)
            ->get();

        // KPI
        $propertiesCount = Property::where($propertyFilter)->count();

        $unitsCount = Unit::whereHas('property', $propertyFilter)
            ->when($unitStatus, fn($q) => $q->where('status', $unitStatus))
            ->count();

        $activeLeasesCount = Lease::whereHas('property', $propertyFilter)
            ->when($leaseStatus, fn($q) => $q->where('status', $leaseStatus))
            ->count();

        $occupiedUnitsCount = Unit::whereHas('property', $propertyFilter)
            ->where('status', 'occupied')
            ->count();

        $occupancyRate = $unitsCount > 0 ? round($occupiedUnitsCount / $unitsCount * 100, 1) : 0;

        // Affitti mensili
        $monthlyRent = Lease::whereHas('property', $propertyFilter)
            ->when($leaseStatus, fn($q) => $q->where('status', $leaseStatus))
            ->sum('rent_total');

        // Grafico entrate/uscite ultimi 6 mesi
        $months = collect();
        $paymentsPerMonth = collect();
        $expensesPerMonth = collect();

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $label = $month->format('m/Y');
            $months->push($label);

            $startM = $month->copy()->startOfMonth();
            $endM   = $month->copy()->endOfMonth();

            $paymentsSum = Payment::whereBetween('due_date', [$startM, $endM])
                ->whereHas('lease.property', $propertyFilter)
                ->sum('amount_total');

            $expensesSum = Expense::whereBetween('date', [$startM, $endM])
                ->whereHas('lease.property', $propertyFilter)
                ->sum('amount_total');

            $paymentsPerMonth->push($paymentsSum);
            $expensesPerMonth->push($expensesSum);
        }

        // Ultimi pagamenti
        $latestPayments = Payment::with('lease.property')
            ->whereHas('lease.property', $propertyFilter)
            ->orderByDesc('due_date')
            ->limit(5)
            ->get();

        // Ultime spese
        $latestExpenses = Expense::with('lease.property')
            ->whereHas('lease.property', $propertyFilter)
            ->orderByDesc('date')
            ->limit(5)
            ->get();

        // Property list for filter
        $properties = Property::whereHas('landlords', fn($q) => $q->whereKey($landlord->id))->get();

        return view('landlord.dashboard.index', compact(
            'properties',
            'propertiesCount',
            'unitsCount',
            'activeLeasesCount',
            'occupancyRate',
            'monthlyRent',
            'months',
            'paymentsPerMonth',
            'expensesPerMonth',
            'latestPayments',
            'latestExpenses',
            'latePayments',
            'expiringLeases',
            'availableUnits',
            'highExpenses',

        ));
    }

}
