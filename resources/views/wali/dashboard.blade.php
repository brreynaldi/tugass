@extends('layouts.app')
@section('title', 'Dashboard Wali')
@section('content')
<div class="container">
    <h2>Dashboard Wali</h2>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>

    <h4>Anak Anda</h4>

    @foreach($anak as $a)
        <div class="card mb-3">
            <div class="card-body">
                <strong>{{ $a->name }} ({{ $a->email }})</strong>
                <p>Kelas yang diikuti:</p>
                <ul>
                    @forelse($a->kelas as $kelas)
                        <li>{{ $kelas->nama }}</li>
                    @empty
                        <li><em>Tidak ada kelas</em></li>
                    @endforelse
                </ul>
                <a href="{{ route('wali.tugas', $a->id) }}" class="btn btn-primary btn-sm">Lihat Tugas</a>
                
            </div>
        </div>
    @endforeach
</div>
@endsection
