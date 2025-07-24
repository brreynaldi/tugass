@extends('layouts.app')
@section('content')
<h3>Daftar Kelas</h3>
<a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">+ Tambah Kelas</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kelas</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kelas as $k)
        <tr>
            <td>{{ $k->nama }}</td>
            <td>
                <a href="{{ route('kelas.show', $k->id) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" style="display:inline-block">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kelas ini?')">Hapus</button>
                </form>
               
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
