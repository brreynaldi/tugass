@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h4>Nilai Jawaban Siswa</h4>

    <p><strong>Siswa:</strong> {{ $jawaban->siswa->name }}</p>
    <p><strong>Tugas:</strong> {{ $jawaban->tugas->judul }}</p>
    <p><strong>File Jawaban:</strong> <a href="{{ asset('storage/'.$jawaban->jawaban) }}" target="_blank">Lihat Jawaban</a></p>

    <form action="{{ route('tugas.nilai.simpan', $jawaban->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control" min="0" max="100" value="{{ $jawaban->nilai }}">
        </div>
        <button type="submit" class="btn btn-success">Simpan Nilai</button>
    </form>
</div>
@endsection
