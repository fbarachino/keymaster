<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nome unità</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $unit->name ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <input type="text" name="type" class="form-control"
                   value="{{ old('type', $unit->type ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Piano</label>
            <input type="number" name="floor" class="form-control"
                   value="{{ old('floor', $unit->floor ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>MQ</label>
            <input type="number" step="0.01" name="size_sqm" class="form-control"
                   value="{{ old('size_sqm', $unit->size_sqm ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Interno</label>
            <input type="text" name="interior" class="form-control"
                   value="{{ old('interior', $unit->interior ?? '') }}">
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Numero vani</label>
            <input type="number" name="rooms" class="form-control"
                   value="{{ old('rooms', $unit->rooms ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Accessorio</label>
            <input type="text" name="accessory" class="form-control"
                   value="{{ old('accessory', $unit->accessory ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Stato</label>
            <select name="status" class="form-control">
                <option value="available" {{ old('status', $unit->status ?? '') == 'available' ? 'selected' : '' }}>Disponibile</option>
                <option value="occupied" {{ old('status', $unit->status ?? '') == 'occupied' ? 'selected' : '' }}>Occupata</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Affitto mensile</label>
            <input type="number" step="0.01" name="monthly_rent" class="form-control"
                   value="{{ old('monthly_rent', $unit->monthly_rent ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Note</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $unit->notes ?? '') }}</textarea>
</div>
