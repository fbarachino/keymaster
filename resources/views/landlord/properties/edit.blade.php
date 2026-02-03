@extends('adminlte::page')

@section('title', 'Modifica proprietà')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Modifica proprietà</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('landlord.properties.update', $property) }}" method="POST">
                @csrf
                @method('PUT')

                @include('landlord.properties.partials.form', ['property' => $property])

                <button class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Aggiorna proprietà
                </button>

                <a href="{{ route('landlord.properties.index') }}" class="btn btn-secondary mt-3">
                    Annulla
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
