<?php

namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Lease;
use App\Services\NotificationService;
use App\Mail\PaymentCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class LandlordPaymentController extends Controller
{
    public function index(Request $request)
    {
        $landlord = $request->user()->landlord;

        $payments = Payment::whereHas('lease.property.landlords', fn($q) =>
            $q->whereKey($landlord->id)
        )
        ->latest('due_date')
        ->paginate(20);

        return view('landlord.payments.index', compact('payments'));
    }

    public function create()
    {
        $leases = Lease::all();
        return view('landlord.payments.create', compact('leases'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'tenant_id' => 'required|exists:tenants,id',
            'due_date' => 'required|date',
            'amount_total' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $payment = Payment::create($data);

        // Notifica interna
        NotificationService::notify(
            $payment->tenant->user,
            'payment_created',
            'Nuovo pagamento disponibile',
            "Hai un nuovo pagamento di {$payment->amount_total} € con scadenza {$payment->due_date}.",
            route('tenant.payments.show', $payment->id)
        );

        // Email
        Mail::to($payment->tenant->user->email)
            ->send(new PaymentCreatedMail($payment));

        return redirect()->route('landlord.payments.index')
            ->with('success', 'Pagamento creato con successo.');
    }

    public function show(Payment $payment)
    {
        return view('landlord.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('landlord.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'due_date' => 'required|date',
            'amount_total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid',
            'paid_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $payment->update($data);

        return redirect()->route('landlord.payments.index')
            ->with('success', 'Pagamento aggiornato.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('landlord.payments.index')
            ->with('success', 'Pagamento eliminato.');
    }
}
