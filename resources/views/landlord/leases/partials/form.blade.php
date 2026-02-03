<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Data inizio</label>
            <input type="date" name="start_date" class="form-control"
                   value="{{ old('start_date', ($lease->start_date ?? null)) }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Data fine</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ old('end_date', ($lease->end_date ?? null)) }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Stato</label>
            @php
                $statusValue = old('status', $lease->status ?? 'active');
            @endphp
            <select name="status" class="form-control">
                <option value="active" {{ $statusValue == 'active' ? 'selected' : '' }}>Attivo</option>
                <option value="pending" {{ $statusValue == 'pending' ? 'selected' : '' }}>In attesa</option>
                <option value="terminated" {{ $statusValue == 'terminated' ? 'selected' : '' }}>Terminato</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Canone totale mensile</label>
            <input type="number" step="0.01" name="rent_total" class="form-control"
                   value="{{ old('rent_total', $lease->rent_total ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Anticipo spese</label>
            <input type="number" step="0.01" name="advance_expense" class="form-control"
                   value="{{ old('advance_expense', $lease->advance_expense ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Deposito cauzionale</label>
            <input type="number" step="0.01" name="deposit" class="form-control"
                   value="{{ old('deposit', $lease->deposit ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Modalità di ripartizione</label>
    @php
        $splitMode = old('split_mode', $lease->split_mode ?? 'equal');
    @endphp
    <select name="split_mode" class="form-control">
        <option value="equal" {{ $splitMode == 'equal' ? 'selected' : '' }}>Divisione equa</option>
        <option value="percentage" {{ $splitMode == 'percentage' ? 'selected' : '' }}>Percentuale per inquilino</option>
        <option value="fixed" {{ $splitMode == 'fixed' ? 'selected' : '' }}>Importo fisso per inquilino</option>
        <option value="unit_based" {{ $splitMode == 'unit_based' ? 'selected' : '' }}>Basato sulle unità</option>
        <option value="custom" {{ $splitMode == 'custom' ? 'selected' : '' }}>Personalizzato</option>
    </select>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Unità coinvolte</label>
            @php
                $selectedUnits = old('units', isset($lease) ? $lease->units->pluck('id')->toArray() : []);
            @endphp
            <select name="units[]" class="form-control" multiple required>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ in_array($unit->id, $selectedUnits) ? 'selected' : '' }}>
                        {{ $unit->name }} ({{ $unit->type }})
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Seleziona una o più unità.</small>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Inquilini</label>
            @php
                $selectedTenants = old('tenants', isset($lease) ? $lease->tenants->pluck('id')->toArray() : []);
            @endphp
            <select name="tenants[]" class="form-control" multiple required>
                @foreach ($tenants as $tenant)
                    <option value="{{ $tenant->id }}"
                        {{ in_array($tenant->id, $selectedTenants) ? 'selected' : '' }}>
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Seleziona uno o più inquilini.</small>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Note</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $lease->notes ?? '') }}</textarea>
</div>
