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

    public function create()
    {
        return view('tenant.messages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'nullable|string',
            'message' => 'required|string',
            'parent_id' => 'nullable|exists:messages,id',
        ]);

        $tenant = $request->user();

        Message::create([
            'tenant_id' => $tenant->id,
            'landlord_id' => $tenant->landlord_id, // se hai questa relazione
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
