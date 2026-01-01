<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandlordMessageController extends Controller
{
    public function index(Request $request)
    {
        $landlord = $request->user();

        return Message::where('sender_id', $landlord->id)
            ->orWhere('receiver_id', $landlord->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store(Request $request)
    {
        $landlord = $request->user();

        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'lease_id' => 'nullable|exists:leases,id',
            'content' => 'required',
        ]);

        $data['sender_id'] = $landlord->id;

        return Message::create($data);
    }
}
