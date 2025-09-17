@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h4>Edit Kelas</h4>
    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Kelas</label>
            <input type="text" name="nama" class="form-control" value="{{ $kelas->nama }}" required>
        </div>

        <div class="form-group">
            <label for="guru_id">Pilih Guru</label>
            <select name="guru_id" class="form-control" required>
                @foreach($guru as $g)
                    <option value="{{ $g->id }}" {{ $kelas->guru_id == $g->id ? 'selected' : '' }}>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection
