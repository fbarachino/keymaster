<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Lease;
use Illuminate\Http\Request;

class LandlordExpenseController extends Controller
{
    /**
     * Mostra tutte le spese dei lease del landlord.
     */
    public function index()
    {
        $expenses = Expense::whereHas('lease.unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->with(['lease.tenant', 'lease.unit.property'])
            ->orderBy('date', 'desc')
            ->get();

        return view('landlord.expenses.index', compact('expenses'));
    }

    /**
     * Form per creare una nuova spesa.
     */
    public function create()
    {
        // Lease appartenenti al landlord
        $leases = Lease::whereHas('unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->with(['tenant', 'unit.property'])
            ->get();

        return view('landlord.expenses.create', compact('leases'));
    }

    /**
     * Salva una nuova spesa.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'charged_to' => 'required|in:landlord,tenant,both',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Verifica che il lease appartenga al landlord
        $lease = Lease::where('id', $data['lease_id'])
            ->whereHas('unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->firstOrFail();

        // Calcolo quote
        $amount = $data['amount'];

        if ($data['charged_to'] === 'tenant') {
            $tenantShare = $amount;
            $landlordShare = 0;
        } elseif ($data['charged_to'] === 'landlord') {
            $tenantShare = 0;
            $landlordShare = $amount;
        } else { // both
            $tenantShare = $amount / 2;
            $landlordShare = $amount / 2;
        }

        Expense::create([
            'lease_id' => $lease->id,
            'type' => $data['type'],
            'amount' => $amount,
            'charged_to' => $data['charged_to'],
            'tenant_share' => $tenantShare,
            'landlord_share' => $landlordShare,
            'date' => $data['date'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('landlord.expenses.index')
            ->with('success', 'Spesa registrata con successo.');
    }

    /**
     * Modifica una spesa.
     */
    public function edit(Expense $expense)
    {
        // Sicurezza: la spesa deve appartenere al landlord
        abort_if(
            $expense->lease->unit->property->landlord_id !== auth()->id(),
            403
        );

        $leases = Lease::whereHas('unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->with(['tenant', 'unit.property'])
            ->get();

        return view('landlord.expenses.edit', compact('expense', 'leases'));
    }

    /**
     * Aggiorna una spesa.
     */
    public function update(Request $request, Expense $expense)
    {
        abort_if(
            $expense->lease->unit->property->landlord_id !== auth()->id(),
            403
        );

        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'charged_to' => 'required|in:landlord,tenant,both',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Verifica lease
        $lease = Lease::where('id', $data['lease_id'])
            ->whereHas('unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->firstOrFail();

        // Calcolo quote
        $amount = $data['amount'];

        if ($data['charged_to'] === 'tenant') {
            $tenantShare = $amount;
            $landlordShare = 0;
        } elseif ($data['charged_to'] === 'landlord') {
            $tenantShare = 0;
            $landlordShare = $amount;
        } else {
            $tenantShare = $amount / 2;
            $landlordShare = $amount / 2;
        }

        $expense->update([
            'lease_id' => $lease->id,
            'type' => $data['type'],
            'amount' => $amount,
            'charged_to' => $data['charged_to'],
            'tenant_share' => $tenantShare,
            'landlord_share' => $landlordShare,
            'date' => $data['date'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('landlord.expenses.index')
            ->with('success', 'Spesa aggiornata con successo.');
    }

    /**
     * Elimina una spesa.
     */
    public function destroy(Expense $expense)
    {
        abort_if(
            $expense->lease->unit->property->landlord_id !== auth()->id(),
            403
        );

        $expense->delete();

        return redirect()
            ->route('landlord.expenses.index')
            ->with('success', 'Spesa eliminata con successo.');
    }
}
