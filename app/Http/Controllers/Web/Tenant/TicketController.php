<?php
namespace App\Http\Controllers\Web\Tenant;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
class TicketController extends Controller
{
public function index(Request $request)
{
    $tickets = Ticket::where('tenant_id', $request->user()->id)->get();
    return view('tenant.tickets.index', compact('tickets'));
}

public function create()
{
    $units = auth()->user()->leases->pluck('unit');
    return view('tenant.tickets.create', compact('units'));
}

public function store(Request $request)
{
    $data = $request->validate([
        'unit_id' => 'required|exists:units,id',
        'title' => 'required',
        'description' => 'required',
    ]);

    $data['tenant_id'] = auth()->id();

    Ticket::create($data);

    return redirect()->route('tenant.tickets.index');
}
public function show(Request $request, Ticket $ticket)
{
    abort_if($ticket->tenant_id !== $request->user()->id, 403);

    return view('tenant.tickets.show', compact('ticket'));
}
}