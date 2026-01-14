@extends('adminlte::page')

@section('title', 'Conguagli Annuali')

@section('content_header')
    <h1>Conguagli Annuali</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Anno</th>
                    <th>Contratto</th>
                    <th>Inquilino</th>
                    <th>Proprietà</th>
                    <th>Documento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->year }}</td>
                        <td>#{{ $report->lease->id }}</td>
                        <td>{{ $report->lease->tenant->name }}</td>
                        <td>{{ $report->lease->unit->property->name }}</td>
                        <td>
                            <a href="{{ route('landlord.yearly-reports.download', $report) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Scarica
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nessun conguaglio disponibile.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
