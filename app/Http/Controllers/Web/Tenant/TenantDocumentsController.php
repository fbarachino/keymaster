<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantDocumentsController extends Controller
{
    //
    public function index(Request $request)
    {
        $tenant = $request->user();

        $leases = $tenant->leases()->with('unit.documents')->get();

        return view('tenant.documents.index', compact('leases'));
    }

}
