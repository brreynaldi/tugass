@extends('layouts.app')
@section('title', 'Tambah Tugas')
@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h4>Buat Tugas Baru</h4>

    <form method="POST" action="{{ route('tugas.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="mb-3">
            <label>Kelas</label>
            
                <select name="kelas_id" class="form-control" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
        
        </div>


        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Tanggal Deadline</label>
            <input type="date" name="tanggal_deadline" class="form-control" required>
        </div>


        <div class="mb-3">
            <label>File Pendukung (opsional)</label>
            <input type="file" name="file" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
