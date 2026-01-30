@extends('tenant.layout')

@section('content')
<div class="container">

    <h2>Archivio Documenti</h2>

    <h3>PDF Mensili</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyPeriods as $period)
            <tr>
                <td>{{ $period }}</td>
                <td>
                    <a href="{{ route('tenant.archive.monthly.pdf', $period) }}"
                       class="btn btn-sm btn-outline-primary">
                        Scarica PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>PDF Annuali</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Anno</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yearlyPeriods as $year)
            <tr>
                <td>{{ $year }}</td>
                <td>
                    <a href="{{ route('tenant.archive.yearly.pdf', $year) }}"
                       class="btn btn-sm btn-outline-primary">
                        Scarica PDF
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
