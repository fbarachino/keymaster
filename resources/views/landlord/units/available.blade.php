{{-- @extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Unità disponibili</h1>

<div class="space-y-4">
    @forelse($units as $unit)
        <div class="bg-white p-4 shadow rounded flex justify-between items-center">
            <div>
                <p class="font-semibold">{{ $unit->property->name }} — {{ $unit->name }}</p>
                @if($unit->description)
                    <p class="text-gray-600 text-sm">{{ $unit->description }}</p>
                @endif
            </div>

            <a href="{{ route('landlord.tenants.index') }}"
            class="bg-blue-600 text-white px-3 py-1 rounded">
                Assegna a un inquilino
            </a>
        </div>
    @empty
        <p>Nessuna unità disponibile al momento.</p>
    @endforelse
</div>
@endsection
 --}}
 @extends('adminlte::page')

@section('title', 'Unità disponibili')

@section('content_header')
    <h1>Unità disponibili</h1>
@stop

@section('content')

<div class="row">
    @forelse($units as $unit)
        <div class="col-md-6">
            <div class="card shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="font-weight-bold mb-1">
                            {{ $unit->property->name }} — {{ $unit->name }}
                        </h5>

                        @if($unit->description)
                            <p class="text-muted mb-0">
                                {{ $unit->description }}
                            </p>
                        @endif
                    </div>

                    <a href="{{ route('landlord.tenants.index') }}"
                       class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Assegna
                    </a>

                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Nessuna unità disponibile al momento.
            </div>
        </div>
    @endforelse
</div>

@stop
