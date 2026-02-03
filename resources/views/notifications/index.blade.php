@extends('layouts.admin')

@section('title', 'Notifiche')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3">Notifiche</h1>

    <div class="card card-outline card-primary">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Titolo</th>
                        <th>Messaggio</th>
                        <th>Data</th>
                        <th>Stato</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($notifications as $n)
                        <tr>
                            <td>{{ $n->title }}</td>
                            <td>{{ $n->message }}</td>
                            <td>{{ $n->created_at }}</td>
                            <td>
                                @if($n->is_read)
                                    <span class="badge badge-secondary">Letta</span>
                                @else
                                    <span class="badge badge-success">Nuova</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if(!$n->is_read)
                                    <form method="POST" action="{{ route('notifications.read', $n) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary">Segna come letta</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Nessuna notifica
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    </div>

</div>
@endsection
