@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h3>{{ $tugas->judul }}</h3>
    <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
   <p><strong>Kelas:</strong> {{ optional($tugas->kelas)->nama ?? '-' }}</p>
    @if($tugas->file)
        <a href="{{ asset('storage/'.$tugas->file) }}" target="_blank" class="btn btn-sm btn-secondary">Unduh File</a>
    @endif

    <hr>
    <h5>Jawaban Siswa:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>File Jawaban</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jawaban as $j)
                <tr>
                    <td>{{ $j->siswa->name }}</td>
                    <td>
                        @if($j->jawaban)
                            <a href="{{ asset('storage/'.$j->jawaban) }}" target="_blank">Lihat</a>
                        @else
                            Belum upload
                        @endif
                    </td>
                    <td>{{ $j->nilai ?? '-' }}</td>
                    <td>
                        <a href="{{ route('tugas.nilai.form', $j->id) }}" class="btn btn-sm btn-primary">Nilai</a>
                    </td>
                </tr>
            @endforeach
         
        </tbody>
    </table>
</div>
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
@endsection
