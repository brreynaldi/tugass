<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tugas;
use App\Models\TugasJawaban;
use App\Models\Quiz;
use App\Models\QuizJawaban;

class WaliController extends Controller
{
    // Dashboard wali: tampilkan daftar anak
    public function index()
    {
        $wali = Auth::user();

        // Load anak dan kelas yang diikuti anak
        $anak = $wali->anak()->with('kelas')->get();

        return view('wali.dashboard', compact('anak'));
    }
    // Tugas anak
    public function tugas($id)
    {
        $anak = User::findOrFail($id);

        // Pastikan hanya wali dari anak tsb yang bisa akses
        if ($anak->wali_id != Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        // Ambil semua kelas anak
        $kelasAnak = $anak->kelas()->pluck('kelas_id');

        // Ambil semua tugas dari kelas yang diikuti anak
        $tugas = \App\Models\Tugas::whereIn('kelas_id', $kelasAnak)->get();

        // Ambil jawaban anak untuk tugas-tugas tersebut
        $jawaban = \App\Models\TugasJawaban::where('siswa_id', $anak->id)->get()->keyBy('tugas_id');

        return view('wali.tugas', compact('anak', 'tugas', 'jawaban'));
    }

    // Quiz anak
    public function quiz($id)
    {
        $anak = User::findOrFail($id);

        if ($anak->wali_id != Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        $jawaban = QuizJawaban::where('siswa_id', $anak->id)->with('quiz')->get();

        return view('wali.quiz', compact('anak', 'jawaban'));
    }
}
