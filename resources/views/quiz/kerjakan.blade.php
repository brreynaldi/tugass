@extends('layouts.app')

@section('content')
<h3>Quiz: {{ $quiz->judul }}</h3>

<form action="{{ route('quiz.simpan', $quiz->id) }}" method="POST">
    @csrf
    @foreach($soal as $i => $item)
        <div class="mb-4">
            <label><strong>Soal {{ $i+1 }}:</strong> {{ $item->pertanyaan }}</label>
            <div class="form-check">
                <input type="radio" name="jawaban_{{ $item->id }}" value="A" class="form-check-input" required>
                <label class="form-check-label">A. {{ $item->opsi_a }}</label>
            </div>
            <div class="form-check">
                <input type="radio" name="jawaban_{{ $item->id }}" value="B" class="form-check-input" required>
                <label class="form-check-label">B. {{ $item->opsi_b }}</label>
            </div>
            <div class="form-check">
                <input type="radio" name="jawaban_{{ $item->id }}" value="C" class="form-check-input" required>
                <label class="form-check-label">C. {{ $item->opsi_c }}</label>
            </div>
            <div class="form-check">
                <input type="radio" name="jawaban_{{ $item->id }}" value="D" class="form-check-input" required>
                <label class="form-check-label">D. {{ $item->opsi_d }}</label>
            </div>
        </div>
    @endforeach
    <button type="submit" class="btn btn-success">Kirim Jawaban</button>
</form>
@endsection
