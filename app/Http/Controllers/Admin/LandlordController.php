<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Landlord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LandlordController extends Controller
{
    public function index()
    {
        $landlords = Landlord::with('user')->whereHas('user', function($query) {
            $query->where('role', 'landlord');
        })->get();


        return view('admin.landlords.index', compact('landlords'));
    }

    public function create()
    {
        return view('admin.landlords.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
        ]);

        $user = User::create(
            [
                'name' => $data['first_name'].' '.$data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'landlord',
            ]);
        $landlord = Landlord::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
           // 'email'      => $data['email'],
            ]);

        return redirect()->route('admin.landlords.index')
            ->with('success', 'Landlord creato correttamente.');
    }

    public function edit(User $landlord)
    {
        return view('admin.landlords.edit', compact('landlord'));
    }

    public function update(Request $request, User $landlord)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,'.$landlord->id,

        ]);

        $landlord->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'name'       => $data['first_name'].' '.$data['last_name'],
            'email'      => $data['email'],
            'role'       => 'landlord',
        ]);

        return redirect()->route('admin.landlords.index')
            ->with('success', 'Landlord aggiornato correttamente.');
    }

    public function destroy(User $landlord)
    {
        $landlord->delete();

        return redirect()->route('admin.landlords.index')
            ->with('success', 'Landlord eliminato.');
    }
}
