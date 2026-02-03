@extends('layouts.admin')

@section('title', 'Contratti attivi')

@section('content_header')
    <h1>Contratti attivi</h1>
@stop

@section('content')

<div class="row">

    @forelse($leases as $lease)
        <div class="col-md-6">
            <div class="card shadow-sm">

                <div class="card-header">
                    <h3 class="card-title">
                        {{ $lease->unit->property->name }} — {{ $lease->unit->name }}
                    </h3>

                    <div class="card-tools">
                        {{-- Stato firma --}}
                        @if($lease->signed_by_tenant_at)
                            <span class="badge badge-success">Firmato</span>
                        @else
                            <span class="badge badge-warning">In attesa firma</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">

                    <p>
                        <strong>Inizio:</strong> {{ $lease->start_date?->format('d/m/Y') }}<br>

                        @if($lease->end_date)
                            <strong>Fine:</strong> {{ $lease->end_date->format('d/m/Y') }}<br>
                        @endif

                        <strong>Canone:</strong>
                        € {{ number_format($lease->rent_amount, 2, ',', '.') }}<br>

                        @if($lease->deposit_amount)
                            <strong>Deposito:</strong>
                            € {{ number_format($lease->deposit_amount, 2, ',', '.') }}<br>
                        @endif
                    </p>

                    {{-- Firma digitale --}}
                    @if(!$lease->signed_by_tenant_at)
                        <a href="{{ route('tenant.leases.sign.show', $lease) }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-pen"></i> Firma digitalmente
                        </a>
                    @else
                        <p class="mt-2 text-success font-weight-bold">
                            Firmato il {{ $lease->signed_by_tenant_at->format('d/m/Y') }}
                        </p>
                    @endif

                </div>

                <div class="card-footer">
                    <a href="{{ route('tenant.leases.pdf', $lease) }}"
                       class="btn btn-outline-secondary btn-sm"
                       target="_blank">
                        <i class="fas fa-file-pdf"></i> Scarica PDF
                    </a>
                    <a href="{{ route('leases.contract.3plus2', $lease) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-file-pdf"></i> Contratto 3+2 (PDF)
                    </a>
                </div>


            </div>
        </div>

    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Nessun contratto attivo al momento.
            </div>
        </div>
    @endforelse

</div>

@stop
