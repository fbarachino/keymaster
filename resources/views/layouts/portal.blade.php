@extends('adminlte::page')

@if(auth()->user()->role === 'tenant')
@section('content_top_nav_left')
<div class="text-lg font-semibold mb-4">
    <a href="{{ route('tenant.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a>
    <a href="{{ route('leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">I miei contratti</a>
    <a href="{{ route('payments.index') }}" class="block p-2 hover:bg-gray-200 rounded">Pagamenti</a>
    <a href="{{ route('messages.index') }}" class="block p-2 hover:bg-gray-200 rounded">Messaggi</a>
</div>
@show
@endif

@if(auth()->user()->role === 'landlord')
@section('content_top_nav_left')
<div class="text-lg font-semibold mb-4">
    <a href="{{ route('landlord.tenants.create') }}" class="block p-2 hover:bg-gray-200 rounded">Aggiungi inquilino</a>
    <a href="{{ route('landlord.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a>
    <a href="{{ route('properties.index') }}" class="block p-2 hover:bg-gray-200 rounded">Proprietà</a>
    <a href="{{ route('leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">Contratti</a>
    <a href="{{ route('messages.index') }}" class="block p-2 hover:bg-gray-200 rounded">Messaggi</a>
    <a href="{{ route('properties.index') }}" class="block p-2 hover:bg-gray-200 rounded">Proprietà & Unità</a>
</div>
@show
@endif

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@show
