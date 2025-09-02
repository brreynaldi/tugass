@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h4>{{ $tugas->judul }}</h4>

    <p>{{ $tugas->deskripsi }}</p>
    @if($tugas->file)
        <a href="{{ asset('storage/'.$tugas->file) }}" target="_blank" class="btn btn-sm btn-secondary">Unduh File</a>
    @endif

    <hr>
    <h5>Jawaban Anda</h5>

    @if($jawaban)
       <p>File: <a href="{{ asset('storage/'.$jawaban->jawaban) }}" target="_blank">Lihat</a></p>
<p><img src="{{ asset('storage/'.$jawaban->jawaban) }}" alt="Preview" style="max-width:200px"></p>


        <p>Nilai: {{ $jawaban->nilai ?? '-' }}</p>
    @else
    
       <form action="{{ route('tugas.jawab', $tugas->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="mb-3">
                <label>Upload Jawaban</label>
                <input type="file" name="jawaban" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form>
    @endif
    <hr>
<h5>💬 Forum Diskusi</h5>

<form action="{{ route('forum.store', $tugas->id) }}" method="POST">
    @csrf
    <textarea name="pesan" class="form-control" required></textarea>
    <button type="submit" class="btn btn-primary mt-2">Kirim</button>
</form>

@foreach($tugas->forums as $forum)
    <div class="mt-3">
        <strong>{{ $forum->user->name }}</strong> <small>{{ $forum->created_at->diffForHumans() }}</small>
        <p>{{ $forum->pesan }}</p>
    </div>
@endforeach

</div>
@endsection
