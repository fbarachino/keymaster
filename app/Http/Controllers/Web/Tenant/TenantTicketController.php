<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;
use Illuminate\Http\Request;

class TenantTicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::where('tenant_id', $request->user()->id)
            ->with('unit.property')
            ->latest()
            ->get();

        return view('tenant.tickets.index', compact('tickets'));
    }

    public function create(Request $request)
    {
        $tenant = $request->user();
        $units = $tenant->leases()->with('unit')->get()->pluck('unit');

        return view('tenant.tickets.create', compact('units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachments.*' => 'image|max:2048',
        ]);

        $tenant = $request->user();
        $unit = $tenant->leases()->where('unit_id', $data['unit_id'])->first()->unit;
        $landlordId = $unit->property->landlord_id;

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('tickets', 'public');
            }
        }

        Ticket::create([
            'tenant_id' => $tenant->id,
            'landlord_id' => $landlordId,
            'unit_id' => $data['unit_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'attachments' => $attachments,
        ]);

        return redirect()->route('tenant.tickets.index')
            ->with('success', 'Ticket creato con successo.');
    }

    public function show(Ticket $ticket)
    {
        abort_if($ticket->tenant_id !== auth()->id(), 403);

        $ticket->load(['notes.user', 'unit.property']);

        return view('tenant.tickets.show', compact('ticket'));
    }
}
