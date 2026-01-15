{{-- @extends('layouts.portal')

@section('content')
<x-adminlte-card title="Nuovo ticket" theme="dark" icon="fas fa-ticket-alt" class="mb-6">
<form method="POST" action="{{ route('tenant.tickets.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1" for="unit_id">Unità</label>
    <select name="unit_id" class="form-control" id="unit_id">
        @foreach($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->property->name }} — {{ $unit->name }}
            </option>
        @endforeach
    </select>
    </div>
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Titolo</label>
    <input type="text" name="title" placeholder="Titolo" class="form-control">
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Descrizione</label>
    <textarea name="description" placeholder="Descrizione del problema" class="form-control"></textarea>
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Priorità</label>
    <select name="priority" class="form-control">
        <option value="low">Bassa</option>
        <option value="medium">Media</option>
        <option value="high">Alta</option>
    </select>
    </div>
    <div class="col mr-4 mb-4">
    <label class="block font-semibold mb-1">Allegati</label>
    <input type="file" name="attachments[]" multiple class="form-control-file">
    </div>
    </div>
    <div class="row">
    <div class="col mr-4 mb-4">
    <button class="btn btn-primary">Invia ticket</button>
    </div>
    </div>
</form>
</x-adminlte-card>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Nuovo ticket')

@section('content_header')
    <h1>Nuovo ticket</h1>
@stop

@section('content')

<x-adminlte-card title="Nuovo ticket" theme="dark" icon="fas fa-ticket-alt" class="mb-4">

    <form method="POST" action="{{ route('tenant.tickets.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- UNITÀ --}}
            <div class="col-md-6 mb-3">
                <label for="unit_id" class="font-weight-bold">Unità</label>
                <select name="unit_id" id="unit_id" class="form-control">
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">
                            {{ $unit->property->name }} — {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TITOLO --}}
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Titolo</label>
                <input type="text" name="title" class="form-control" placeholder="Titolo del ticket">
            </div>

        </div>


        {{-- DESCRIZIONE --}}
        <div class="mb-3">
            <label class="font-weight-bold">Descrizione</label>
            <textarea name="description" class="form-control" rows="4"
                      placeholder="Descrivi il problema in modo dettagliato"></textarea>
        </div>


        <div class="row">

            {{-- PRIORITÀ --}}
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Priorità</label>
                <select name="priority" class="form-control">
                    <option value="low">Bassa</option>
                    <option value="medium">Media</option>
                    <option value="high">Alta</option>
                </select>
            </div>

            {{-- ALLEGATI --}}
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Allegati</label>
                <input type="file" name="attachments[]" multiple class="form-control">
            </div>

        </div>

        <button class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Invia ticket
        </button>

    </form>

</x-adminlte-card>

@stop
