@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tugas Anak: {{ $anak->name }}</h4>
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">← Kembali</a>
    </div>
    <br/>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul Tugas</th>
                <th>Jawaban</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jawaban as $jawab)
                <tr>
                    <td>{{ $jawab->tugas->judul }}</td>
                    <td>
                        @if($jawab->file)
                            <a href="{{ asset('storage/' . $jawab->file) }}" target="_blank">Lihat File</a>
                        @else
                            Belum upload
                        @endif
                    </td>
                    <td>{{ $jawab->nilai ?? 'Belum dinilai' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
