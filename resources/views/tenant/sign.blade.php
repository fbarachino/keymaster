@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Firma contratto</h1>

<canvas id="signature" class="border w-full h-64 bg-white"></canvas>

<button id="clear" class="mt-2 bg-gray-500 text-white px-4 py-2 rounded">Pulisci</button>

<form method="POST" action="{{ route('tenant.leases.sign', $lease) }}" class="mt-4">
    @csrf
    <input type="hidden" name="signature" id="signature_input">
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Firma contratto</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature');
    const signaturePad = new SignaturePad(canvas);

    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('signature_input').value = signaturePad.toDataURL();
    });

    document.getElementById('clear').onclick = () => signaturePad.clear();
</script>
@endsection
