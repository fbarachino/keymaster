@extends('adminlte::page')

@section('title', 'Profilo utente')

@section('content_header')
    <h1>Profilo utente</h1>
@stop

@section('content')

@if(session('success'))
    <x-adminlte-alert theme="success" title="Successo">
        {{ session('success') }}
    </x-adminlte-alert>
@endif

@if ($errors->any())
    <x-adminlte-alert theme="danger" title="Errore">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-adminlte-alert>
@endif

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user"></i> Modifica profilo</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            {{-- NOME + EMAIL --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Nome</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}">
                </div>
            </div>

            {{-- LINGUA + NOTIFICHE --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Lingua</label>
                    <select name="language" class="form-control">
                        <option value="it" {{ $user->language == 'it' ? 'selected' : '' }}>Italiano</option>
                        <option value="en" {{ $user->language == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ $user->language == 'es' ? 'selected' : '' }}>Español</option>
                        <option value="fr" {{ $user->language == 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="de" {{ $user->language == 'de' ? 'selected' : '' }}>Deutsch</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Preferenza notifiche</label>
                    <select name="notification_preference" class="form-control">
                        <option value="email" {{ $user->notification_preference == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="telegram" {{ $user->notification_preference == 'telegram' ? 'selected' : '' }}>Telegram</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Telegram Chat ID</label>
                    <input type="text" name="telegram_chat_id" class="form-control"
                           value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}">
                    <small class="text-muted">Necessario solo se scegli Telegram</small>
                </div>
            </div>

            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna profilo
            </button>

        </form>

    </div>
</div>

@stop
