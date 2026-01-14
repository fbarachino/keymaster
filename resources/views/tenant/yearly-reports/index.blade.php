@extends('adminlte::page')

@section('title', 'Conguagli Annuali')

@section('content_header')
    <h1>I tuoi conguagli annuali</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Anno</th>
                    <th>Proprietà</th>
                    <th>Unità</th>
                    <th>Documento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->year }}</td>
                        <td>{{ $report->lease->unit->property->name }}</td>
                        <td>{{ $report->lease->unit->name }}</td>
                        <td>
                            <a href="{{ route('tenant.yearly-reports.download', $report) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Scarica
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nessun conguaglio disponibile.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
