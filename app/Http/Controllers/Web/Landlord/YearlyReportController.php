<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\YearlyReport;
use Illuminate\Support\Facades\Storage;

class YearlyReportController extends Controller
{
    public function index()
    {
        $reports = YearlyReport::whereHas('lease.unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->with(['lease.tenant', 'lease.unit.property'])
            ->orderBy('year', 'desc')
            ->get();

        return view('landlord.yearly-reports.index', compact('reports'));
    }

    public function download(YearlyReport $report)
    {
        abort_if(
            $report->lease->unit->property->landlord_id !== auth()->id(),
            403
        );

        return Storage::disk('public')->download($report->file_path);
    }
}
