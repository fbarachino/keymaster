<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class LandlordMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::where('landlord_id', $request->user()->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('landlord.messages.index', compact('messages'));
    }

    public function create()
    {
        $tenants = User::where('role', 'tenant')->get();

        return view('landlord.messages.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'subject' => 'nullable|string',
            'message' => 'required|string',
            'parent_id' => 'nullable|exists:messages,id',
        ]);

        Message::create([
            'tenant_id' => $data['tenant_id'],
            'landlord_id' => auth()->id(),
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'parent_id' => $data['parent_id'] ?? null,
            'sender' => 'landlord',
        ]);

        return redirect()->route('landlord.messages.index')
            ->with('success', 'Messaggio inviato.');
    }

    public function show(Message $message)
    {
        abort_if($message->landlord_id !== auth()->id(), 403);

        return view('landlord.messages.show', compact('message'));
    }
}
