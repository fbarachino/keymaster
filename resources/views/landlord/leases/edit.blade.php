@extends('adminlte::page')

@section('title', 'Modifica contratto')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Modifica contratto per {{ $property->name }}</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.leases.update', [$property, $lease]) }}" method="POST">
                @csrf
                @method('PUT')

                @include('landlord.leases.partials.form', ['lease' => $lease])

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Aggiorna contratto
                </button>

                <a href="{{ route('landlord.leases.index', $property) }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
