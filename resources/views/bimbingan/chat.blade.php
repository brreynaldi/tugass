@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Chat Bimbingan</h4>
    <div class="card">
        <div class="card-body">
            {{-- Chat List --}}
            @forelse($bimbingan->chat as $chat)
                <div>
                    <strong>{{ $chat->pengirim->name }}
                    
                </div>
                <div>
                    </strong> {{ $chat->message }}
                </div>
                <div>
                    <small class="text-muted float-right">{{ $chat->created_at->diffForHumans() }}</small>
                </div>

                <hr>
            @empty
                <p>Belum ada chat.</p>
            @endforelse

            <form action="{{ route('bimbingan.kirimChat', $bimbingan->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="message" class="form-control" placeholder="Ketik pesan..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
            <form action="{{ route('bimbingan.selesai', $bimbingan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyelesaikan bimbingan ini?')">
                @csrf
                <button type="submit" class="btn btn-success">Selesai</button>
            </form>
        </div>
    </div>
</div>
@endsection
