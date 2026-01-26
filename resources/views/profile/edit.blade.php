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

            <hr class="my-4">

<h4>Dati personali</h4>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Nome</label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $user->first_name) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Cognome</label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $user->last_name) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Data di nascita</label>
        <input type="date" name="birth_date" class="form-control"
               value="{{ old('birth_date', $user->birth_date) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Luogo di nascita</label>
        <input type="text" name="birth_place" class="form-control"
               value="{{ old('birth_place', $user->birth_place) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Codice fiscale</label>
        <input type="text" name="fiscal_code" class="form-control"
               value="{{ old('fiscal_code', $user->fiscal_code) }}">
    </div>
</div>

<hr class="my-4">

<h4>Residenza</h4>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Indirizzo</label>
        <input type="text" name="address" class="form-control"
               value="{{ old('address', $user->address) }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="font-weight-bold">CAP</label>
        <input type="text" name="zip" class="form-control"
               value="{{ old('zip', $user->zip) }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="font-weight-bold">Città</label>
        <input type="text" name="city" class="form-control"
               value="{{ old('city', $user->city) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Provincia</label>
        <input type="text" name="province" class="form-control"
               value="{{ old('province', $user->province) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Stato</label>
        <input type="text" name="country" class="form-control"
               value="{{ old('country', $user->country) }}">
    </div>
</div>

<hr class="my-4">

<h4>Documento</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Tipo documento</label>
        <input type="text" name="document_type" class="form-control"
               value="{{ old('document_type', $user->document_type) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Numero</label>
        <input type="text" name="document_number" class="form-control"
               value="{{ old('document_number', $user->document_number) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Ente rilascio</label>
        <input type="text" name="document_issuer" class="form-control"
               value="{{ old('document_issuer', $user->document_issuer) }}">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Data rilascio</label>
        <input type="date" name="document_issue_date" class="form-control"
               value="{{ old('document_issue_date', $user->document_issue_date) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Data scadenza</label>
        <input type="date" name="document_expiry_date" class="form-control"
               value="{{ old('document_expiry_date', $user->document_expiry_date) }}">
    </div>
</div>

<hr class="my-4">

<h4>Contatti</h4>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Telefono</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $user->phone) }}">
    </div>
</div>


            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Aggiorna profilo
            </button>

        </form>

    </div>
</div>

@stop
