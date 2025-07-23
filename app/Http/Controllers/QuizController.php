<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quiz = Quiz::where('guru_id', Auth::id())->get();
        return view('quiz.index', compact('quiz'));
    }

    public function create()
    {
        return view('quiz.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kelas_id' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        Quiz::create([
            'judul' => $request->judul,
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dibuat');
    }

    public function edit(Quiz $quiz)
    {
        return view('quiz.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->only('judul', 'kelas_id', 'tanggal_mulai', 'tanggal_selesai'));
        return redirect()->route('quiz.index')->with('success', 'Quiz diperbarui');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Quiz dihapus');
    }
}
