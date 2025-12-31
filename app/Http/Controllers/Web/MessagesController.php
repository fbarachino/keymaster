<?php

namespace App\Http\Controllers\Web;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['tenant', 'landlord'])->get();

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required',
        ]);

        $data['sender_id'] = auth()->id();

        Message::create($data);

        return redirect()->route('messages.index');
    }

    public function show(Message $message)
    {
        abort_if($message->sender_id !== auth()->id() && $message->receiver_id !== auth()->id(), 403);

        return view('messages.show', compact('message'));
    }
}
