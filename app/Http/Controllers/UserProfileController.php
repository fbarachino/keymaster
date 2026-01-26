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
       /*  $validated = $request->validate([
            'name'                     => 'required|string|max:255',
            'email'                    => 'required|email',
            'language'                 => 'required|in:it,en,es,de,fr',
            'notification_preference'  => 'required|in:email,telegram',
            'telegram_chat_id'         => 'nullable|string',
        ]); */

        $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',

    // dati personali
    'first_name' => 'nullable|string|max:255',
    'last_name' => 'nullable|string|max:255',
    'birth_date' => 'nullable|date',
    'birth_place' => 'nullable|string|max:255',
    'fiscal_code' => 'nullable|string|max:16',
    'nationality' => 'nullable|string|max:255',

    // residenza
    'address' => 'nullable|string|max:255',
    'zip' => 'nullable|string|max:10',
    'city' => 'nullable|string|max:255',
    'province' => 'nullable|string|max:255',
    'country' => 'nullable|string|max:255',

    // documento
    'document_type' => 'nullable|string|max:255',
    'document_number' => 'nullable|string|max:255',
    'document_issue_date' => 'nullable|date',
    'document_expiry_date' => 'nullable|date',
    'document_issuer' => 'nullable|string|max:255',

    // contatti
    'phone' => 'nullable|string|max:20',

    // preferenze
    'language' => 'required|in:it,en,es,de,fr',
    'notification_preference' => 'required|in:email,telegram',
    'telegram_chat_id' => 'nullable|string',
]);


        $user = auth()->user();
        $user->update($validated);

        return back()->with('success', 'Profilo aggiornato correttamente.');
    }
}
