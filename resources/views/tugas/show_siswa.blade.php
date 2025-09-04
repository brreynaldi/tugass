@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <div>
        <h4> Nama Tugas : {{ $tugas->judul }}</h4> 
        <br/>
        <h5> Keterangan Tugas :{{ $tugas->deskripsi }} </h5>
        <h5> Tanggal Pengumpulan Tugas Terakhir : {{ \Carbon\Carbon::parse($tugas->tanggal_deadline)->format('d F Y') }}</h5>
    </div>

    @if($tugas->file)
        <a href="{{ asset('storage/'.$tugas->file) }}" target="_blank" class="btn btn-sm btn-secondary">Unduh File</a>
    @endif

    <hr>
    <h5>Jawaban Anda</h5>

     @if($jawaban)
     <a href="{{ asset('storage/'.$jawaban->jawaban) }}" target="_blank" class="btn btn-sm btn-secondary">Lihat Jawaban</a>
    <p>Nilai: {{ $jawaban->nilai ?? '-' }}</p>
    @else
        {{-- Cek apakah sudah lewat deadline --}}
        @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($tugas->tanggal_deadline)))
            <div class="alert alert-warning">
                ⚠️ Anda tidak dapat mengirim jawaban dikarenakan sudah melewati tanggal pengumpulan.
            </div>
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
