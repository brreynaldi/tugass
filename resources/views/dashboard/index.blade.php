@extends('layouts.app')
@section('content')
    <h3>Dashboard ({{ $user->role }})</h3>

    @if($user->role == 'admin')
        <p>Total Pengguna: {{ $data['total_users'] }}</p>
        <p>Total Kelas: {{ $data['total_kelas'] }}</p>
    @elseif($user->role == 'guru')
        <p>Kelas Saya:</p>
        <ul>
            @foreach($data['kelas'] as $k)
                <li>{{ $k->nama }}</li>
            @endforeach
        </ul>
    @else
        <p>Kelas Anda:</p>
        <ul>
            @foreach($data['kelas'] as $k)
                <li>{{ $k->nama }}</li>
            @endforeach
        </ul>
    @endif
@endsection
