@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Inquilini senza contratto</h1>
<a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-user-plus"></i> Nuovo Tenant
</a>
<div class="space-y-4">
    @foreach($tenants as $tenant)
        <div class="bg-white p-4 shadow rounded flex justify-between items-center">
            <div>
                <p class="font-semibold">{{ $tenant->name }}</p>
                <p class="text-gray-600">{{ $tenant->email }}</p>
            </div>

            <a href="{{ route('landlord.tenants.assignForm', $tenant) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Assegna unità
            </a>
        </div>
    @endforeach
</div>
@endsection
