<?php
namespace App\Http\Controllers\Web\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Lease;
use App\Notifications\PaymentRegistered;
use Illuminate\Http\Request;
use PDF;

class LandlordPaymentController extends Controller
{
    /*public function index()
    {
        $payments = Payment::with('tenant')
            ->where('landlord_id', auth()->id())
            ->latest()
            ->get();

        return view('landlord.payments.index', compact('payments'));
    }*/
    public function index()
    {
        $payments = Payment::whereHas('lease.unit.property', function ($q) {
    $q->where('landlord_id', auth()->id());
})
->orderBy('due_date', 'desc')
->get();
        return view('landlord.payments.index', compact('payments'));
    }


    public function create()
    {
        // Tutti i tenant del landlord
        $tenants = User::where('role', 'tenant')
            ->whereHas('leases.unit.property', fn($q) => $q->where('landlord_id', auth()->id()))
            ->get();

        return view('landlord.payments.create', compact('tenants'));
    }

    /* public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Payment::create([
            'tenant_id' => $data['tenant_id'],
            'landlord_id' => auth()->id(),
            'amount' => $data['amount'],
            'reference' => $data['reference'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'paid',
        ]);

        return redirect()->route('landlord.payments.index')
            ->with('success', 'Pagamento registrato con successo.');
    } */

public function store(Request $request)
{
    $data = $request->validate([
        'tenant_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:0.01',
        'reference' => 'nullable|string',
        'notes' => 'nullable|string',
        'due_date' => 'required|date',
    ]);

    // Recupera il lease del tenant
    /*$lease = Lease::where('tenant_id', $data['tenant_id'])
        ->where('landlord_id', auth()->id())
        ->firstOrFail();*/
        $lease = Lease::where('tenant_id', $data['tenant_id'])
    ->whereHas('unit.property', function ($q) {
        $q->where('landlord_id', auth()->id());
    })
    ->firstOrFail();


    Payment::create([
        'lease_id' => $lease->id,
        'amount' => $data['amount'],
        'reference' => $data['reference'] ?? null,
        'notes' => $data['notes'] ?? null,
        'status' => 'paid',
        'due_date' => $data['due_date'],
        'paid_date' => now(), // opzionale
    ]);

    $tenant = $lease->tenant;
    $tenant->notify(new PaymentRegistered($payment));


    return redirect()->route('landlord.payments.index')
        ->with('success', 'Pagamento registrato con successo.');
}



public function receipt(Payment $payment)
{
    $payment->load('lease.tenant', 'lease.unit.property');

    $pdf = PDF::loadView('pdf.receipt', compact('payment'));

    return $pdf->download('ricevuta_' . $payment->id . '.pdf');
}



}
