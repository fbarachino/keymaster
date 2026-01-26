<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|email',
            'language'                 => 'required|in:it,en,es,de,fr',
            'notification_preference'  => 'required|in:email,telegram',
            'telegram_chat_id'         => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return back()->with('success', 'Profilo aggiornato correttamente.');
    }
}
