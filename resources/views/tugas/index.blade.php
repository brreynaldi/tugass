@extends('layouts.app')
@section('title', 'Daftar Tugas')
@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h4>Daftar Tugas</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::user()->role == 'guru')
        <a href="{{ route('tugas.create') }}" class="btn btn-primary mb-3">+ Buat Tugas</a>
        <a href="{{ route('tugas.export.semua') }}" class="btn btn-success mb-3">📤 Export Semua Nilai</a>

    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tugas as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kelas->nama ?? '-' }}</td>
                    <td>
                        @if(Auth::user()->role == 'guru')
                            <a href="{{ route('tugas.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" style="display:inline-block">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus Tugas Ini?')">Hapus</button>
                            </form>
                        @elseif(Auth::user()->role == 'siswa')
                            <a href="{{ route('siswa.tugas.show', $item->id) }}" class="btn btn-sm btn-info">Lihat</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
