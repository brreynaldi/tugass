@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tugas {{ $anak->name }}</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul Tugas</th>
                <th>Deskripsi</th>
                <th>Jawaban</th>
                <th>Nilai</th>
            </tr>
        </thead>
       <tbody>
                @foreach($tugas as $t)
                    <tr>
                        <td>{{ $t->judul }}</td>
                        <td>{{ $t->deskripsi }}</td>
                        <td>
                            @if(isset($jawaban[$t->id]))
                                
                                
                                @if($jawaban[$t->id]->jawaban)
                                    <a href="{{ asset('storage/'.$jawaban[$t->id]->jawaban) }}" 
                                    target="_blank" 
                                    class="btn btn-sm btn-secondary mt-2">
                                        Lihat Jawaban
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">Belum mengumpulkan</span>
                            @endif
                        </td>
                        <td>
                            @if(isset($jawaban[$t->id]) && $jawaban[$t->id]->nilai !== null)
                                {{ $jawaban[$t->id]->nilai }}
                            @else
                                <span class="text-muted">Belum dinilai</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>
</div>
@endsection
