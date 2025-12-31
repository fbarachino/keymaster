@extends('adminlte::page')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Inquilino</h1>

<div class="grid grid-cols-3 gap-4">

    <div class="p-4 bg-white shadow rounded">
        <h2 class="font-semibold">Contratti attivi</h2>
        <p class="text-3xl">{{ $leases->count() }}</p>
    </div>

    <div class="p-4 bg-white shadow rounded">
        <h2 class="font-semibold">Pagamenti in sospeso</h2>
        <p class="text-3xl">{{ $pending }}</p>
    </div>

    <div class="p-4 bg-white shadow rounded">
        <h2 class="font-semibold">Messaggi non letti</h2>
        <p class="text-3xl">{{ $unread }}</p>
    </div>

</div>
@endsection
