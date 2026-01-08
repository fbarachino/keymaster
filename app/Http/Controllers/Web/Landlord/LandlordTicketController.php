<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketNote;
use Illuminate\Http\Request;

class LandlordTicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::where('landlord_id', $request->user()->id)
            ->with(['tenant', 'unit.property'])
            ->latest()
            ->get();

        return view('landlord.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        abort_if($ticket->landlord_id !== auth()->id(), 403);

        $ticket->load(['notes.user', 'tenant', 'unit.property']);

        return view('landlord.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        abort_if($ticket->landlord_id !== auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Stato aggiornato.');
    }

    public function addNote(Request $request, Ticket $ticket)
    {
        abort_if($ticket->landlord_id !== auth()->id(), 403);

        $data = $request->validate([
            'note' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        TicketNote::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'note' => $data['note'],
            'is_internal' => $data['is_internal'] ?? false,
        ]);

        return back()->with('success', 'Nota aggiunta.');
    }
}
