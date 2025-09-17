@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Siswa</h3>

    <div class="row g-4">

        {{-- 1. Kelas --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('kelas.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="bi bi-journal-richtext display-4 text-primary"></i>
                        <h6 class="mt-2 text-dark">Kelas</h6>
                    </div>
                </div>
            </a>
        </div>

        {{-- 2. Tugas --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('tugas.index') }}" class="text-decoration-none">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="bi bi-clipboard-check display-4 text-success"></i>
                        <h6 class="mt-2 text-dark">Tugas</h6>
                    </div>
                </div>
            </a>
        </div>


        {{-- 4. Logout --}}
        <div class="col-6 col-md-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="card text-center shadow-sm h-100 w-100 btn btn-link p-0" style="border:none;">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <i class="bi bi-box-arrow-right display-4 text-danger"></i>
                        <h6 class="mt-2 text-dark">Keluar</h6>
                    </div>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
