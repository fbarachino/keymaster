@extends('layouts.admin')

@section('title', 'Nuovo contratto')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Nuovo contratto per {{ $property->name }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.leases.store', $property) }}" method="POST">
                @csrf

                @include('landlord.leases.partials.form')

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Salva contratto
                </button>

                <a href="{{ route('landlord.leases.index', $property) }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
