<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $property->name ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Prezzo di acquisto</label>
            <input type="number" step="0.01" name="purchase_price" class="form-control"
                   value="{{ old('purchase_price', $property->purchase_price ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Descrizione</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $property->description ?? '') }}</textarea>
</div>

<h5 class="mt-4">Indirizzo</h5>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Indirizzo</label>
            <input type="text" name="address" class="form-control"
                   value="{{ old('address', $property->address ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>CAP</label>
            <input type="text" name="zip" class="form-control"
                   value="{{ old('zip', $property->zip ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Città</label>
            <input type="text" name="city" class="form-control"
                   value="{{ old('city', $property->city ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Provincia</label>
            <input type="text" name="province" class="form-control"
                   value="{{ old('province', $property->province ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Nazione</label>
            <input type="text" name="country" class="form-control"
                   value="{{ old('country', $property->country ?? '') }}">
        </div>
    </div>
</div>

<h5 class="mt-4">Dati catastali</h5>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Foglio</label>
            <input type="text" name="cadastral_sheet" class="form-control"
                   value="{{ old('cadastral_sheet', $property->cadastral_sheet ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Particella</label>
            <input type="text" name="cadastral_particle" class="form-control"
                   value="{{ old('cadastral_particle', $property->cadastral_particle ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Subalterno</label>
            <input type="text" name="cadastral_sub" class="form-control"
                   value="{{ old('cadastral_sub', $property->cadastral_sub ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Categoria catastale</label>
            <input type="text" name="cadastral_category" class="form-control"
                   value="{{ old('cadastral_category', $property->cadastral_category ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Classe</label>
            <input type="text" name="cadastral_class" class="form-control"
                   value="{{ old('cadastral_class', $property->cadastral_class ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Rendita catastale</label>
            <input type="number" step="0.01" name="cadastral_rent" class="form-control"
                   value="{{ old('cadastral_rent', $property->cadastral_rent ?? '') }}">
        </div>
    </div>
</div>
