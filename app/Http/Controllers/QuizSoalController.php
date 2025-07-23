<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSoal;
use Illuminate\Http\Request;

class QuizSoalController extends Controller
{
    public function index($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $soal = QuizSoal::where('quiz_id', $quiz_id)->get();
        return view('quiz.soal.index', compact('quiz', 'soal'));
    }

    public function create($quiz_id)
    {
        return view('quiz.soal.create', ['quiz_id' => $quiz_id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'jawaban_benar' => 'required|in:A,B,C,D',
        ]);

        QuizSoal::create($request->all());

        return back()->with('success', 'Soal ditambahkan');
    }

    public function destroy($id)
    {
        QuizSoal::findOrFail($id)->delete();
        return back()->with('success', 'Soal dihapus');
    }
}
