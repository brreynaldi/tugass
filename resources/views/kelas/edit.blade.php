@extends('layouts.app')

@section('content')
<div class="container">
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
