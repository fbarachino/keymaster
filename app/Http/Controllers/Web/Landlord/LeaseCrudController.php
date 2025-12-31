<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Lease;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaseCrudController extends Controller
{
    public function index(Request $request)
    {
        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', $request->user()->id)
        )->with(['unit.property', 'tenant'])->get();

        return view('landlord.leases.index', compact('leases'));
    }

    public function create()
    {
        $units = Unit::whereHas('property', fn($q) =>
            $q->where('landlord_id', auth()->id())
        )->get();

        $tenants = User::where('role', 'tenant')->get();

        return view('landlord.leases.create', compact('units', 'tenants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'rent_amount' => 'required|numeric',
        ]);

        Lease::create($data);

        return redirect()->route('landlord.leases.index');
    }
}
