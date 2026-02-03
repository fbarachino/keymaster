@extends('adminlte::page')

@section('title', 'Landlords')

@section('content_header')
    <h1>Gestione Landlords</h1>
@stop

@section('content')

<a href="{{ route('admin.landlords.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-user-plus"></i> Nuovo Landlord
</a>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($landlords as $landlord)
                    <tr>
                        <td>{{ $landlord->first_name }} {{ $landlord->last_name }}</td>
                        <td>{{ $landlord->user->email }}</td>
                        <td>
                            <a href="{{ route('admin.landlords.edit', $landlord) }}" class="btn btn-warning btn-sm">
                                Modifica
                            </a>

                            <form action="{{ route('admin.landlords.destroy', $landlord) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Elimina
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
