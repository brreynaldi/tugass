@extends('layouts.app')
@section('content')
<h3>Detail Kelas: {{ $kelas->nama }}</h3>
<div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
<h5>Daftar Siswa:</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($anggota as $siswa)
        <tr>
            <td>{{ $siswa->name }}</td>
            <td>{{ $siswa->email }}</td>
            <td>
                <form action="{{ route('kelas.hapusSiswa', $kelas->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $siswa->id }}">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@if(Auth::check() && Auth::user()->role === 'guru')
<h5>Tambah Siswa ke Kelas:</h5>
<form action="{{ route('kelas.tambahSiswa', $kelas->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($semua_siswa as $s)
                    @if(!$anggota->contains($s))
                        <option value="{{ $s->id }}">{{ $s->name }} - {{ $s->email }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success">Tambah</button>
        </div>
    </div>
</form>
 @endif
@endsection
