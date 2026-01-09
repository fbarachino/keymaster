<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class TenantMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::where('tenant_id', $request->user()->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('tenant.messages.index', compact('messages'));
    }

    public function create(Request $request)
    {
        $tenant = $request->user();

        // Se il tenant NON ha contratti → deve scegliere il landlord
        if ($tenant->leases()->count() === 0) {
            $landlords = User::where('role', 'landlord')->get();
            return view('tenant.messages.create', compact('landlords'));
        } else {
            $landlords = $tenant->leases()->with('unit.property')->get()
                ->map(function ($lease) {
                    return $lease->unit->property->landlord;
                })->unique('id')    ;
        }

        // Se ha un contratto → nessuna scelta
        return view('tenant.messages.create', compact('landlords'));
    }


    public function store(Request $request)
{
    $tenant = $request->user();

    // Tenant con contratto → landlord automatico
    if ($tenant->leases()->count() > 0) {
        $landlordId = $tenant->leases()->first()->unit->property->landlord_id;
    }
    // Tenant senza contratto → landlord scelto dal form
    else {
        $landlordId = $request->validate([
            'landlord_id' => 'required|exists:users,id'
        ])['landlord_id'];
    }

    $data = $request->validate([
        'subject' => 'nullable|string',
        'message' => 'required|string',
        'parent_id' => 'nullable|exists:messages,id',
    ]);

    Message::create([
        'tenant_id' => $tenant->id,
        'landlord_id' => $landlordId,
        'subject' => $data['subject'] ?? null,
        'message' => $data['message'],
        'parent_id' => $data['parent_id'] ?? null,
        'sender' => 'tenant',
    ]);

    return redirect()->route('tenant.messages.index')
        ->with('success', 'Messaggio inviato.');
}


    public function show(Message $message)
    {
        abort_if($message->tenant_id !== auth()->id(), 403);

        return view('tenant.messages.show', compact('message'));
    }
}
