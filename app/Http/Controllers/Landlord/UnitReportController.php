<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Unit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF as dPDF;
use PDF as PDF; // se usi DomPDF o Snappy
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UnitReportController extends Controller
{
    // Mostra la pagina HTML del report
    /* public function show(Unit $unit)
    {
        $unit->load([
            'property.landlord',
            'leases.tenants',
            'leases.payments',
            'expenses',
            'documents',
            'photos',
            'inventory.items',
        ]);

        return view('landlord.units.report', compact('unit'));
    }
 */
public function show(Unit $unit)
{
    $unit->load([
        'property.landlord',
        'leases.tenants',
        'leases.payments',
        'expenses',
        'documents',
        'photos',
        'inventory',
    ]);

    // Calcolo mesi
    $months = collect(range(1, 12))->map(fn($m) =>
        \Carbon\Carbon::create(null, $m, 1)->format('M')
    );

    // Incassi
    $income = collect(range(1, 12))->map(function ($month) use ($unit) {
        return $unit->leases
            ->flatMap->payments
            ->filter(fn($p) => \Carbon\Carbon::parse($p->date)->month == $month)
            ->sum('amount');
    });

    // Spese
    $expenses = collect(range(1, 12))->map(function ($month) use ($unit) {
        return $unit->expenses
            ->filter(fn($e) => \Carbon\Carbon::parse($e->date)->month == $month)
            ->sum('amount');
    });

    // Rendita
    $profit = $income->zip($expenses)->map(fn($pair) => $pair[0] - $pair[1]);

    return view('landlord.units.report', compact(
        'unit',
        'months',
        'income',
        'expenses',
        'profit'
    ));
}

    // Genera il PDF
    public function pdf(Unit $unit)
    {
        $unit->load([
            'property.landlord',
            'leases.tenants',
            'leases.payments',
            'expenses',
            'documents',
            'photos',
            'inventory',
        ]);

      //  $chartImage = $this->generateChartImage($unit);
        $chartImage = $this->generateChartImage($unit);
        $pdf = PDF::loadView('landlord.units.report-pdf',
        [ 'unit' => $unit, 'chartImage' => $chartImage, ])->setPaper('a4', 'portrait');

        /*$pdf = PDF::loadView('landlord.units.report-pdf', compact('unit'))
            ->setPaper('a4', 'portrait');*/

        return $pdf->download('Unit_Report_'.$unit->id.'.pdf');
    }
    /* protected function generateChartImage($unit)
    {
        $data = [
            'months' => [...],
            'income' => [...],
            'expenses' => [...],
            'profit' => [...],
        ];

        $chart = \QuickChart::new()
            ->width(800)
            ->height(300)
            ->backgroundColor('white')
            ->format('png')
            ->chart([
                'type' => 'line',
                'data' => [
                    'labels' => $data['months'],
                    'datasets' => [
                        ['label' => 'Incassi', 'data' => $data['income']],
                        ['label' => 'Spese', 'data' => $data['expenses']],
                        ['label' => 'Rendita', 'data' => $data['profit']],
                    ]
                ]
            ]);

        return $chart->toBase64();
    } */
    protected function generateChartImage(Unit $unit)
    {
        // 1) Mesi
        $months = collect(range(1, 12))->map(fn($m) =>
            \Carbon\Carbon::create(null, $m, 1)->format('M')
        );

        // 2) Incassi
        $income = collect(range(1, 12))->map(function ($month) use ($unit) {
            return $unit->leases
                ->flatMap->payments
                ->filter(fn($p) => \Carbon\Carbon::parse($p->date)->month == $month)
                ->sum('amount');
        });

        // 3) Spese
        $expenses = collect(range(1, 12))->map(function ($month) use ($unit) {
            return $unit->expenses
                ->filter(fn($e) => \Carbon\Carbon::parse($e->date)->month == $month)
                ->sum('amount');
        });

        // 4) Rendita
        $profit = $income->zip($expenses)->map(fn($pair) => $pair[0] - $pair[1]);

        // 5) Configurazione grafico
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $months->toArray(),
                'datasets' => [
                    [
                        'label' => 'Incassi',
                        'data' => $income->toArray(),
                        'borderColor' => 'green',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Spese',
                        'data' => $expenses->toArray(),
                        'borderColor' => 'red',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Rendita',
                        'data' => $profit->toArray(),
                        'borderColor' => 'blue',
                        'fill' => false,
                    ],
                ],
            ],
            'options' => [
                'legend' => ['position' => 'bottom'],
                'scales' => [
                    'yAxes' => [[ 'ticks' => ['beginAtZero' => true] ]]
                ]
            ]
        ];

        // 6) Chiamata HTTP a QuickChart
        $response = Http::post('https://quickchart.io/chart', [
            'chart' => $chartConfig,
            'format' => 'png',
            'width' => 800,
            'height' => 300,
            'backgroundColor' => 'white',
        ]);

        // 7) Restituisce immagine base64
        return base64_encode($response->body());
    }


}


