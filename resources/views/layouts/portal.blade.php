<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Portal' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="flex bg-gray-100">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow h-screen p-4">
        <h2 class="text-xl font-bold mb-6">Rental Manager</h2>

        <nav class="space-y-2">

            @if(auth()->user()->role === 'tenant')
                <a href="{{ route('tenant.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="{{ route('leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">I miei contratti</a>
                <a href="{{ route('payments.index') }}" class="block p-2 hover:bg-gray-200 rounded">Pagamenti</a>
                <a href="{{ route('messages.index') }}" class="block p-2 hover:bg-gray-200 rounded">Messaggi</a>
            @endif

            @if(auth()->user()->role === 'landlord')
                <a href="{{ route('landlord.tenants.create') }}" class="block p-2 hover:bg-gray-200 rounded">Aggiungi inquilino</a>
                <a href="{{ route('landlord.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="{{ route('properties.index') }}" class="block p-2 hover:bg-gray-200 rounded">Proprietà</a>
                <a href="{{ route('leases.index') }}" class="block p-2 hover:bg-gray-200 rounded">Contratti</a>
                <a href="{{ route('messages.index') }}" class="block p-2 hover:bg-gray-200 rounded">Messaggi</a>
                <a href="{{ route('properties.index') }}" class="block p-2 hover:bg-gray-200 rounded">Proprietà & Unità</a>
            @endif

        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</body>
</html>
