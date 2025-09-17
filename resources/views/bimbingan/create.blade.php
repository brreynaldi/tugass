@extends('layouts.app')
@section('title', 'Ajukan Bimbingan')
@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h3>Ajukan Permintaan Bimbingan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('bimbingan.store') }}" method="POST">
        @csrf

        {{-- Guru --}}
        <div class="form-group mb-3">
            <label for="guru_id">Pilih Guru</label>
            <select name="guru_id" id="guru_id" class="form-control" required>
                <option value="">-- Pilih Guru --</option>
                @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Siswa (khusus role wali) --}}
        @if (auth()->user()->role === 'wali')
        <div class="form-group mb-3">
            <label for="siswa_id">Pilih Siswa</label>
            <select name="siswa_id" id="siswa_id" class="form-control">
                <option value="">-- Pilih Siswa --</option>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Pesan --}}
        <div class="form-group mb-3">
            <label for="pesan">Pesan</label>
            <textarea name="pesan" id="pesan" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Bimbingan</button>
    </form>
</div>
@endsection
