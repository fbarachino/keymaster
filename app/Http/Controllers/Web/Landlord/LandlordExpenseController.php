<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Lease;
use App\Models\Property;
use Illuminate\Http\Request;

class LandlordExpenseController extends Controller
{
    public function index(Request $request)
    {
        $landlord = $request->user()->landlord;

        $expenses = Expense::whereHas('property.landlords', fn($q) =>
            $q->whereKey($landlord->id)
        )
        ->latest('expense_date')
        ->paginate(20);

        return view('landlord.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $properties = Property::all();
        $leases = Lease::all();

        return view('landlord.expenses.create', compact('properties', 'leases'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'lease_id' => 'required|exists:leases,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'amount_total' => 'required|numeric|min:0',
            'amount_tenant' => 'nullable|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        Expense::create($data);

        return redirect()->route('landlord.expenses.index')
            ->with('success', 'Spesa registrata con successo.');
    }

    public function show(Expense $expense)
    {
        return view('landlord.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $properties = Property::all();
        $leases = Lease::all();

        return view('landlord.expenses.edit', compact('expense', 'properties', 'leases'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'lease_id' => 'required|exists:leases,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'amount_total' => 'required|numeric|min:0',
            'amount_tenant' => 'nullable|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($data);

        return redirect()->route('landlord.expenses.index')
            ->with('success', 'Spesa aggiornata.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('landlord.expenses.index')
            ->with('success', 'Spesa eliminata.');
    }
}
