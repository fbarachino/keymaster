@extends('adminlte::page')

    @section('right_sidebar')
        @if(auth()->user()->role === 'tenant')
            <div>
                <li><a href="{{ route('tenant.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a></li>
                <li><a href="{{ route('tenant.leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">I miei contratti</a></li>
                <li><a href="{{ route('tenant.payments.index') }}" class="block p-2 hover:bg-gray-200 rounded">Pagamenti</a></li>
                <li><a href="{{ route('tenant.messages.index') }}" class="block p-2 hover:bg-gray-200 rounded">Messaggi</a></li>
                <li><a href="{{ route('tenant.tickets.index') }}" class="block p-2 hover:bg-gray-200 rounded">Ticket di manutenzione</a></li>
            </li>

            </div
        @elseif(auth()->user()->role === 'landlord')
            <div>
                <li><a href="{{ route('landlord.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a></li>
                <li><a href="{{ route('landlord.tenants.create') }}" class="block p-2 hover:bg-gray-200 rounded">Aggiungi inquilino</a></li>
                <li><a href="{{ route('landlord.tenants.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-200">Inquilini & Contratti</a></li>
                <li><a href="{{ route('landlord.properties.index') }}" class="block p-2 hover:bg-gray-200 rounded">Proprietà</a></li>
                <li><a href="{{ route('landlord.leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">Contratti</a></li>
                <li><a href="{{ route('landlord.payments.index') }}"class="flex items-center px-4 py-2 hover:bg-gray-200">Pagamenti</a></li>
                <li><a href="{{ route('landlord.tickets.index') }}"class="flex items-center px-4 py-2 hover:bg-gray-200">Ticket di manutenzione</a></li>
                <li><a href="{{ route('landlord.maintenance.dashboard') }}"class="flex items-center px-4 py-2 hover:bg-gray-200">Dashboard manutenzioni</a></li>
                <li><a href="{{ route('landlord.messages.index') }}" class="flex items-center px-4 py-2 hover:bg-gray-200">Messaggi</a></li>
                <li><a href="{{ route('landlord.messages.create') }}"class="flex items-center px-4 py-2 hover:bg-gray-200">Nuovo messaggio</a></li>
            </div>
        @endif
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @show
