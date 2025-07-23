@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Riwayat Notifikasi</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-group">
        @forelse ($notifikasi as $notif)
            <li class="list-group-item d-flex justify-content-between align-items-start 
                {{ is_null($notif->read_at) ? 'list-group-item-warning' : 'list-group-item-light' }}">
                <div class="ms-2 me-auto">
                    <div>{{ $notif->data['message'] }}</div>
                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                @if(is_null($notif->read_at))
                    <form action="{{ route('notifikasi.read.one', $notif->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">Tandai dibaca</button>
                    </form>
                @else
                    <span class="badge bg-success rounded-pill">✓</span>
                @endif
            </li>
        @empty
            <li class="list-group-item">Tidak ada notifikasi.</li>
        @endforelse
    </ul>
</div>
@endsection
