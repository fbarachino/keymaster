<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Models\Lease;
use App\Models\Payment;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user();

        $leases = Lease::where('tenant_id', $tenant->id)->with('unit.property')->get();
        $pending = Payment::whereHas('lease', fn($q) =>
            $q->where('tenant_id', $tenant->id)
        )->where('status', 'pending')->count();

        $unread = Message::where('receiver_id', $tenant->id)
            ->whereNull('read_at')
            ->count();

        return view('tenant.dashboard', compact('leases', 'pending', 'unread'));
    }
}
