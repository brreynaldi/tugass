<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSoal;
use App\Models\QuizJawaban;
use App\Models\QuizJawabanSiswa;
use Illuminate\Http\Request;
use Auth;

class QuizJawabanController extends Controller
{
    public function kerjakan($quiz_id)
    {
         $cek = QuizJawaban::where('quiz_id', $quiz_id)
                      ->where('siswa_id', Auth::id())
                      ->first();

        if ($cek) {
            return redirect()->route('dashboard')
                            ->with('info', 'Anda sudah mengerjakan quiz ini.');
        }
        $quiz = Quiz::findOrFail($quiz_id);
        $soal = QuizSoal::where('quiz_id', $quiz_id)->get();
        
        return view('quiz.kerjakan', compact('quiz', 'soal'));
    }

    public function simpanJawaban(Request $request, $quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $soal = QuizSoal::where('quiz_id', $quiz_id)->get();

        $nilai = 0;
        foreach ($soal as $s) {
            $jawaban = $request->input('jawaban_' . $s->id);

            // Simpan jawaban siswa
            QuizJawabanSiswa::create([
                'quiz_id' => $quiz_id,
                'quiz_soal_id' => $s->id,
                'siswa_id' => Auth::id(),
                'jawaban' => $jawaban
            ]);

            if ($jawaban == $s->jawaban_benar) {
                $nilai++;
            }
        }

        // Simpan total nilai
        QuizJawaban::create([
            'quiz_id' => $quiz_id,
            'siswa_id' => Auth::id(),
            'nilai' => $nilai
        ]);

        return redirect()->route('dashboard')->with('success', 'Quiz selesai. Nilai Anda: ' . $nilai);
    }
}
