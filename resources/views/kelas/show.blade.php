@extends('layouts.app')
@section('title', 'Lihat Kelas')
@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-collection"></i> Detail Kelas: <span class="text-dark">{{ $kelas->nama }}</span>
        </h3>
        <button onclick="history.back()" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="bi bi-arrow-left"></i> Kembali
        </button>
    </div>

    <!-- Daftar Siswa -->
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header text-white rounded-top-3" style="background: linear-gradient(90deg, #0d6efd, #0dcaf0);">
            <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Siswa</h5>
        </div>
        <div class="card-body">
            @if(auth()->user()->role === 'guru' || auth()->user()->role === 'admin')
            <form action="{{ route('kelas.hapusSiswaBatch', $kelas->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:50px;" class="text-center">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>Nama</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota as $siswa)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="user_ids[]" value="{{ $siswa->id }}" class="form-check-input checkbox-item">
                                </td>
                                <td><i class="bi bi-person-circle text-primary me-1"></i><strong>{{ $siswa->name }}</strong></td>
                                <td class="text-muted">{{ $siswa->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-outline-danger mt-3 rounded-pill">
                    <i class="bi bi-trash"></i> Hapus Terpilih
                </button>
            </form>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $siswa)
                        <tr>
                            <td><i class="bi bi-person-circle text-primary me-1"></i><strong>{{ $siswa->name }}</strong></td>
                            <td class="text-muted">{{ $siswa->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Tambah Siswa -->
     
     @if(auth()->user()->role === 'guru' || auth()->user()->role === 'admin')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header text-white rounded-top-3" style="background: linear-gradient(90deg, #198754, #20c997);">
            <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Siswa ke Kelas</h5>
        </div>
        <div class="card-body">
            @php
                $sisa_siswa = $semua_siswa->whereNotIn('id', $anggota->pluck('id'));
            @endphp

            @if($sisa_siswa->isEmpty())
                <div class="alert alert-success text-center rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i> Semua siswa sudah terdaftar di kelas ini 🎉
                </div>
            @else
                <form action="{{ route('kelas.tambahSiswa', $kelas->id) }}" method="POST">
                    @csrf

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label for="select-all-tambah" class="fw-bold text-success mb-0">
                            <input type="checkbox" id="select-all-tambah" class="form-check-input me-1"> Pilih Semua
                        </label>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px;" class="text-center">Pilih</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sisa_siswa as $siswa)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="user_id[]" value="{{ $siswa->id }}" class="form-check-input siswa-checkbox">
                                    </td>
                                    <td><i class="bi bi-person-circle text-success me-1"></i><strong>{{ $siswa->name }}</strong></td>
                                    <td class="text-muted">{{ $siswa->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success mt-3 rounded-pill">
                        <i class="bi bi-person-check-fill"></i> Tambahkan Siswa
                    </button>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Script -->
<script>
    // Select All daftar siswa
    document.getElementById('select-all')?.addEventListener('change', function () {
        document.querySelectorAll('.checkbox-item').forEach(cb => cb.checked = this.checked);
    });

    // Select All tambah siswa
    document.getElementById('select-all-tambah')?.addEventListener('change', function () {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
