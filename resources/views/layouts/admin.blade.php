@extends('adminlte::page')
@section('content_top_nav_right')

    @php
        $user = auth()->user();
        $unreadNotifications = \App\Models\Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->take(10)
            ->get();
    @endphp

    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            @if($unreadNotifications->count() > 0)
                <span class="badge badge-warning navbar-badge">{{ $unreadNotifications->count() }}</span>
            @endif
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <span class="dropdown-item dropdown-header">
                {{ $unreadNotifications->count() }} notifiche
            </span>

            <div class="dropdown-divider"></div>

            @forelse($unreadNotifications as $n)
                <a href="{{ $n->link ?? '#' }}" class="dropdown-item">
                    <i class="fas fa-info-circle mr-2"></i> {{ $n->title }}
                    <span class="float-right text-muted text-sm">
                        {{ $n->created_at->diffForHumans() }}
                    </span>
                </a>
                <div class="dropdown-divider"></div>
            @empty
                <span class="dropdown-item text-center text-muted">Nessuna nuova notifica</span>
            @endforelse

            <div class="dropdown-divider"></div>

            <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">
                Vedi tutte le notifiche
            </a>

        </div>
    </li>

@endsection
