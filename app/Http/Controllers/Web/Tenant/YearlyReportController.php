<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\YearlyReport;
use Illuminate\Support\Facades\Storage;

class YearlyReportController extends Controller
{
    public function index()
    {
        $reports = YearlyReport::whereHas('lease', function ($q) {
                $q->where('tenant_id', auth()->id());
            })
            ->with(['lease.unit.property'])
            ->orderBy('year', 'desc')
            ->get();

        return view('tenant.yearly-reports.index', compact('reports'));
    }

    public function download(YearlyReport $report)
    {
        abort_if(
            $report->lease->tenant_id !== auth()->id(),
            403
        );

        return Storage::disk('public')->download($report->file_path);
    }
}
