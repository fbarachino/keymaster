@extends('adminlte::page')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard Inquilino</h1>
    <div class="row">
        <div class="col-md-3">
        <x-adminlte-info-box title="Contratti Attivi" text="{{ $leases->count() }}" icon="fas fa-lg fa-download" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Pagamenti in sospeso" text="{{ $pending }}" icon="fas fa-lg fa-coins" icon-theme="purple"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-info-box title="Messaggi non letti" text="{{ $unread }}" icon="fas fa-lg fa-file" icon-theme="purple"/>
        </div>


</div>
@endsection
