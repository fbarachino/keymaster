<?php

namespace App\Http\Controllers\Web\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantMessageController extends Controller
{
public function index(Request $request)
{
    $threads = Thread::where('tenant_id', $request->user()->id)
        ->latest()
        ->get();

    return view('tenant.messages.index', compact('threads'));
}


    /*public function create(Request $request)
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
    }*/
 /*       public function create()
{
    $tenant = Auth::user();

    // Se il tenant ha un contratto → usa il suo landlord
    $lease = $tenant->leases()->with('unit.property.landlord')->first();

    if ($lease) {
        $landlord = $lease->unit->property->landlord;
    } else {
        // Landlord predefinito (il primo landlord del sistema)
        /*$landlord = User::where('role', 'landlord')->first();*/
        /*$landlords = User::where('role', 'landlord')->get();
            //return view('tenant.messages.create', compact('landlords'));
    }

    return view('tenant.messages.create', compact('landlord'));
} */

public function create()
{
    $tenant = auth()->user();

    // Se il tenant ha un contratto → usa il suo landlord
    $lease = $tenant->leases()->with('unit.property.landlord')->first();

    if ($lease) {
        $landlords = $lease->unit->property->landlord;
    } else {
        // Landlord predefinito
        $landlords = User::where('role', 'landlord')->first();
    }

    return view('tenant.messages.create', compact('landlords'));
}


   /* public function store(Request $request)
{
   // dd($request->all());
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
        'tenant_id' => 'nullable|exists:users,id',
    ]);
// dd(($request->all()));
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
}*/
public function store(Request $request)
{
    $data = $request->validate([
        'subject' => 'nullable|string',
        'message' => 'required|string',
    ]);

    $tenant = auth()->user();

    // Se il tenant ha un contratto → usa il suo landlord
    $lease = $tenant->leases()->with('unit.property.landlord')->first();

    if ($lease) {
        $landlord = $lease->unit->property->landlord;
    } else {
        // Landlord predefinito
        $landlord = User::where('role', 'landlord')->first();
    }

    // Crea il thread
    $thread = Thread::create([
        'tenant_id' => $tenant->id,
        'landlord_id' => $landlord->id,
        'subject' => $data['subject'],
    ]);
    $thread->refresh();
    // Primo messaggio
    Message::create([
        'thread_id' => $thread->id,
        'tenant_id' => $tenant->id,
        'landlord_id' => $landlord->id,
        'sender' => 'tenant',
        'message' => $data['message'],
    ]);

    return redirect()->route('tenant.messages.show', $thread);
}



    public function show(Thread $thread)
    {
        abort_if($thread->tenant_id !== auth()->id(), 403);

        $messages = $thread->messages()->orderBy('created_at')->get();

        return view('tenant.messages.show', compact('thread', 'messages'));
    }

    public function reply(Request $request, Thread $thread)
{
    abort_if($thread->tenant_id !== auth()->id(), 403);

    $request->validate([
        'message' => 'required|string',
    ]);

    Message::create([
        'thread_id' => $thread->id,
        'tenant_id' => auth()->id(),
        'landlord_id' => $thread->landlord_id,
        'sender' => 'tenant',
        'message' => $request->message,
    ]);

    return back();
}

}
