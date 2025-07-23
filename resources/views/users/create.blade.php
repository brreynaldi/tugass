@extends('layouts.app')
@section('content')
<h3>Tambah Pengguna</h3>
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control" onchange="toggleAnakField(this.value)">
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="guru" {{ old('role', $user->role ?? '') == 'guru' ? 'selected' : '' }}>Guru</option>
        <option value="siswa" {{ old('role', $user->role ?? '') == 'siswa' ? 'selected' : '' }}>Siswa</option>
        <option value="wali" {{ old('role', $user->role ?? '') == 'wali' ? 'selected' : '' }}>Wali</option>
    </select>
</div>

<div class="mb-3" id="anakField" style="display: none;">
    <label for="wali_id">Pilih Wali </label>
    <select name="wali_id" class="form-control">
        <option value="">-- Pilih Wali --</option>
        @foreach ($waliList as $wali)
            <option value="{{ $wali->id }}"
                {{ (old('wali_id', $user->wali_id ?? '') == $wali->id) ? 'selected' : '' }}>
                {{ $wali->name }}
            </option>
        @endforeach
    </select>
</div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
@push('scripts')
<script>
    function toggleAnakField(role) {
        const anakField = document.getElementById('anakField');
        anakField.style.display = (role === 'siswa') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleAnakField(document.getElementById('role').value);
    });
</script>
@endpush
