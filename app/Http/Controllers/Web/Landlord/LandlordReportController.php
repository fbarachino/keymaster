<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LandlordReportController extends Controller
{
    public function propertyReport(Property $property)
    {
        $payments = Payment::whereHas('lease', fn($q) =>
            $q->where('property_id', $property->id)
        )->get();

        $pdf = Pdf::loadView('landlord.reports.property', compact('property', 'payments'));

        return $pdf->download("report-proprieta-{$property->id}.pdf");
    }
}
