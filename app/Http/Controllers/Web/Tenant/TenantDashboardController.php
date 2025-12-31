<?php

namespace App\Http\Controllers\Portal\Tenant;

use App\Models\Lease;
use App\Models\Message;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenant = $request->user();

        return [
            'leases' => Lease::where('tenant_id', $tenant->id)
                ->with('unit.property')
                ->get(),

            'pending_payments' => Payment::whereHas('lease', fn($q) =>
                $q->where('tenant_id', $tenant->id)
            )->where('status', 'pending')->get(),

            'unread_messages' => Message::where('receiver_id', $tenant->id)
                ->whereNull('read_at')
                ->count(),
        ];
    }
}
