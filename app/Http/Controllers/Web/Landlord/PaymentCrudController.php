<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Models\Payment;
use App\Models\Lease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentCrudController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::whereHas('lease.unit.property', fn($q) =>
            $q->where('landlord_id', $request->user()->id)
        )->with(['lease.unit.property', 'lease.tenant'])->get();

        return view('landlord.payments.index', compact('payments'));
    }

    public function create()
    {
        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', auth()->id())
        )->with(['unit.property', 'tenant'])->get();

        return view('landlord.payments.create', compact('leases'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        Payment::create($data);

        return redirect()->route('landlord.payments.index');
    }

    public function edit(Payment $payment)
    {
        abort_if($payment->lease->unit->property->landlord_id !== auth()->id(), 403);

        $leases = Lease::whereHas('unit.property', fn($q) =>
            $q->where('landlord_id', auth()->id())
        )->get();

        return view('landlord.payments.edit', compact('payment', 'leases'));
    }

    public function update(Request $request, Payment $payment)
    {
        abort_if($payment->lease->unit->property->landlord_id !== auth()->id(), 403);

        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'due_date' => 'required|date',
            'paid_date' => 'nullable|date',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        $payment->update($data);

        return redirect()->route('landlord.payments.index');
    }

    public function destroy(Payment $payment)
    {
        abort_if($payment->lease->unit->property->landlord_id !== auth()->id(), 403);

        $payment->delete();

        return redirect()->route('landlord.payments.index');
    }
}
