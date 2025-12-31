@extends('layouts.portal')

@section('content')
<h1 class="text-2xl font-bold mb-6">Notifiche</h1>

<div class="space-y-4">
    @foreach(auth()->user()->notifications as $notification)
        <div class="bg-white p-4 shadow rounded">
            <p>{{ $notification->data['message'] }}</p>
            <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @endforeach
</div>
@endsection
