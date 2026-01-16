<?php
namespace App\Http\Controllers\Web\Landlord;

use Log;
use PDF;
use App\Models\User;
use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Jobs\ProcessPaymentJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PaymentRegistered;


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
        /*$tenants = User::where('role', 'tenant')
            ->whereHas('leases.unit.property', fn($q) => $q->where('landlord_id', auth()->id()))
            ->get();

        return view('landlord.payments.create', compact('tenants'));*/
         $leases = Lease::whereHas('unit.property', function ($q) {
            $q->where('landlord_id', auth()->id());
         }) ->with(['tenant', 'unit.property']) ->get();

         return view('landlord.payments.create', compact('leases'));
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

/* public function store(Request $request)
{

        $lease = Lease::where('tenant_id', $data['tenant_id'])
    ->whereHas('unit.property', function ($q) {
        $q->where('landlord_id', auth()->id());
    })
    ->firstOrFail();



    Payment::create([
    'lease_id' => $data['lease_id'],
    'amount' => $data['amount'],
    'due_date' => $data['due_date'],
    'reference' => $data['reference'] ?? null,
    'notes' => $data['notes'] ?? null,
    'status' => 'paid',
    'paid_date' => now(),
    'type' => $data['type'], // <--- IMPORTANTE
]);


    $tenant = $lease->tenant;
    $tenant->notify(new PaymentRegistered($payment));


    return redirect()->route('landlord.payments.index')
        ->with('success', 'Pagamento registrato con successo.');
} */

public function store(Request $request)
{
    $data = $request->validate([
        'lease_id' => 'required|exists:leases,id',
        'amount' => 'required|numeric|min:0.01',
        'reference' => 'nullable|string',
        'notes' => 'nullable|string',
        'due_date' => 'required|date',
        'type' => 'required|in:rent,deposit,expense,other',
    ]);

    // Recupera il lease e verifica che appartenga al landlord
    $lease = Lease::where('id', $data['lease_id'])
        ->whereHas('unit.property', function ($q) {
            $q->where('landlord_id', auth()->id());
        })
        ->firstOrFail();

    // Crea il pagamento
    $payment = Payment::create([
        'lease_id' => $lease->id,
        'amount' => $data['amount'],
        'due_date' => $data['due_date'],
        'reference' => $data['reference'] ?? null,
        'notes' => $data['notes'] ?? null,
        'status' => 'pending',
        'paid_date' => now(),
        'type' => $data['type'],
    ]);

    // Notifica al tenant
    $lease->tenant->notify(new PaymentRegistered($payment));
    // ProcessPaymentJob::dispatch($payment);
    //return back()->with('success', 'Pagamento registrato. PDF e notifica in elaborazione.');

    return redirect()->route('landlord.payments.index')
        ->with('success', 'Pagamento registrato. PDF e notifica in elaborazione.');
}

public function edit(Payment $payment)
{
    abort_if(
        $payment->lease->unit->property->landlord_id !== auth()->id(),
        403
    );

    $leases = Lease::whereHas('unit.property', function ($q) {
            $q->where('landlord_id', auth()->id());
        })
        ->with(['tenant', 'unit.property'])
        ->get();

    return view('landlord.payments.edit', compact('payment', 'leases'));
}

public function update(Request $request, Payment $payment)
{
    $data = $request->validate([
        'lease_id' => 'required|exists:leases,id',
        'amount' => 'required|numeric|min:0.01',
        'reference' => 'nullable|string',
        'notes' => 'nullable|string',
        'due_date' => 'required|date',
        'paid_date' => 'nullable|date',
        'type' => 'required|in:rent,deposit,expense,other',
    ]);

    // Verifica che il lease appartenga al landlord
    $lease = Lease::where('id', $data['lease_id'])
        ->whereHas('unit.property', function ($q) {
            $q->where('landlord_id', auth()->id());
        })
        ->firstOrFail();

    $payment->update([
        'lease_id' => $lease->id,
        'amount' => $data['amount'],
        'due_date' => $data['due_date'],
        'paid_date' => $data['paid_date'],
        'reference' => $data['reference'] ?? null,
        'notes' => $data['notes'] ?? null,
        'type' => $data['type'],
    ]);

    return redirect()->route('landlord.payments.index')
        ->with('success', 'Pagamento aggiornato con successo.');
}

public function destroy(Lease $lease, Payment $payment)
{
    // Sicurezza: il pagamento deve appartenere al lease
   /* if ($payment->lease_id !== $lease->id) {
        abort(403, 'Pagamento non appartenente a questo contratto.');
    }*/

    // Se esiste un PDF associato, lo eliminiamo
    if ($payment->pdf_path && Storage::exists($payment->pdf_path)) {
        Storage::delete($payment->pdf_path);
    }

    // Elimina il pagamento
    $payment->delete();

    // Log utile
    Log::info("Pagamento {$payment->id} eliminato dal landlord.", [
        'lease_id' => $lease->id ?? null,
        'user_id' => auth()->id(),
    ]);

    return back()->with('success', 'Pagamento eliminato correttamente.');
}



public function receipt(Payment $payment)
{
    $payment->load('lease.tenant', 'lease.unit.property');

    $pdf = PDF::loadView('pdf.receipt', compact('payment'));

    return $pdf->download('ricevuta_' . $payment->id . '.pdf');
}

public function markPaid(Payment $payment)
{
    abort_if(
        $payment->lease->unit->property->landlord_id !== auth()->id(),
        403
    );
    ProcessPaymentJob::dispatch($payment);

    $payment->update([
        'status' => 'paid',
        'paid_date' => now(),
    ]);

    return redirect()->route('landlord.payments.index')
        ->with('success', 'Pagamento segnato come pagato.');
}


}
