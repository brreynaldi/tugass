@extends('layouts.app')

@section('content')
<h3>Buat Quiz Baru</h3>

<form action="{{ route('quiz.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="judul">Judul Quiz</label>
        <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="kelas_id">Kelas</label>
        <select name="kelas_id" class="form-control" required>
            @foreach(auth()->user()->kelas as $kelas)
                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
