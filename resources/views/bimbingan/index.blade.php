@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <button onclick="history.back()" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
</button>
    </div>
    <br/>
    <h3>Daftar Bimbingan Saya</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Topik</th>
                <th>Guru</th>
                <th>Siswa</th>
                <th>Wali</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bimbingans as $bimbingan)
                <tr>
                    <td>{{ $bimbingan->pesan }}</td>
                    <td>{{ $bimbingan->guru->name ?? '-' }}</td>
                    <td>{{ $bimbingan->siswa->name ?? '-' }}</td>
                    <td>{{ $bimbingan->wali->name ?? '-' }}</td>
                    <td>{{ $bimbingan->created_at->format('d M Y H:i') }}</td>
                    <td>{{ ucfirst($bimbingan->status) }}</td>
                    <td>
                        @if(Auth::user()->id === $bimbingan->guru_id && $bimbingan->status == 'menunggu')
                            <form action="{{ route('bimbingan.terima', $bimbingan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <form action="{{ route('bimbingan.tolak', $bimbingan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @endif

                        @if($bimbingan->status === 'disetujui')
                            <a href="{{ route('bimbingan.chat', $bimbingan->id) }}" class="btn btn-primary btn-sm">Lihat Chat</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data bimbingan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
