<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\TugasJawaban;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SiswaSubmitTugas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiExport;
use App\Notifications\GuruBuatTugas;


class TugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'guru') {
           $tugas = Tugas::with('kelas')->where('guru_id', $user->id)->get();
        } elseif ($user->role == 'siswa') {
            $kelasIds = $user->kelas->pluck('id');
            $tugas = Tugas::with('kelas')->whereIn('kelas_id', $kelasIds)->get();
        } elseif ($user->role == 'wali') {
            $anakIds = $user->anak->pluck('id'); // anak adalah collection
            $tugas = TugasJawaban::with('tugas')
                ->whereIn('siswa_id', $anakIds)
                ->get();
        } else {
            $tugas = Tugas::all();
        }
        
        return view('tugas.index', compact('tugas'));
    }

    public function create()
    {
        $user = Auth::user();

        $kelas = \App\Models\Kelas::where('guru_id', $user->id)->get(); // langsung ambil dari tabel

        return view('tugas.create', compact('kelas'));
    }


    public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string',
        'kelas_id' => 'required|exists:kelas,id',
        'deskripsi' => 'nullable|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip,rar,jpg,jpeg,png,gif,bmp,svg,webp,mp4,mkv,avi,mov,mp3,wav,ogg',
        'tanggal_deadline' => 'required|date'
    ]);

    $path = $request->file('file') ? $request->file('file')->store('tugas', 'public') : null;

    $tugas = Tugas::create([
        'judul' => $request->judul,
        'kelas_id' => $request->kelas_id,
        'guru_id' => Auth::id(),
        'deskripsi' => $request->deskripsi,
        'file' => $path,
        'tanggal_deadline' => $request->tanggal_deadline
    ]);

    // Kirim notifikasi ke siswa dan wali
    $kelas = $tugas->kelas;
    foreach ($kelas->siswa as $siswa) {
        $siswa->notify(new GuruBuatTugas(Auth::user(), $tugas));
        if ($siswa->wali) {
            $siswa->wali->notify(new GuruBuatTugas(Auth::user(), $tugas));
        }
    }

    return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dibuat dan notifikasi dikirim.');
}


    public function show($id)
    {
        $user = Auth::user();
        $tugas = Tugas::findOrFail($id); // Manual cari

        if ($user->role == 'guru') {
            $jawaban = TugasJawaban::where('tugas_id', $tugas->id)->with('siswa')->get();
            return view('tugas.show', compact('tugas', 'jawaban'));
        }

        if ($user->role == 'siswa') {
            $jawaban = TugasJawaban::where('tugas_id', $tugas->id)
                        ->where('siswa_id', $user->id)->first();
            return view('tugas.show_siswa', compact('tugas', 'jawaban'));
        }

        if ($user->role == 'wali') {
            $anak = $user->anak;
            $jawaban = TugasJawaban::where('tugas_id', $tugas->id)
                        ->where('siswa_id', $anak->id)->first();
            return view('tugas.show_wali', compact('tugas', 'jawaban'));
        }
    }


    public function storeJawaban(Request $request, $tugas_id)
    {
        $request->validate([
            'jawaban' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv,ppt,pptx,zip,rar,jpg,jpeg,png,gif,bmp,svg,webp,mp4,mkv,avi,mov,mp3,wav,ogg'
        ]);

        $filePath = $request->file('jawaban')->store('jawaban', 'public');

        $tugas = Tugas::findOrFail($tugas_id);

        $jawaban = TugasJawaban::updateOrCreate(
            ['tugas_id' => $tugas_id, 'siswa_id' => Auth::id()],
            ['jawaban' => $filePath]
        );

        $siswa = Auth::user();
        $guru = $tugas->guru;
        $wali = $siswa->wali; // pastikan relasi wali tersedia

        if ($guru) {
            $guru->notify(new SiswaSubmitTugas($siswa, $tugas));
        }

        if ($wali) {
            $wali->notify(new SiswaSubmitTugas($siswa, $tugas));
        }

        return redirect()->route('tugas.index')->with('success', 'Jawaban berhasil dikirim.');
    }

    public function nilaiForm($jawaban_id)
    {
        $jawaban = TugasJawaban::with('siswa', 'tugas')->findOrFail($jawaban_id);
        return view('tugas.nilai', compact('jawaban'));
    }


    public function nilaiSimpan(Request $request, $id)
        {
            $request->validate([
                'nilai' => 'required|numeric|min:0|max:100'
            ]);

            $jawaban = TugasJawaban::findOrFail($id);
            $jawaban->nilai = $request->nilai;
            $jawaban->save();

            $siswa = $jawaban->siswa; // pastikan relasi siswa ada di model TugasJawaban
            $tugas = $jawaban->tugas;

            // Kirim ke siswa
            // // if ($siswa) {
            // //     $siswa->notify(new NilaiTugasDiberikan($tugas, $request->nilai));
            // // }

            // // Kirim ke wali
            // if ($siswa && $siswa->wali) {
            //     $siswa->wali->notify(new NilaiTugasDiberikan($tugas, $request->nilai));
            // }

            return redirect()->route('tugas.show', $tugas->id)->with('success', 'Nilai berhasil disimpan.');
        }

    public function exportNilai($tugas_id)
    {
        return Excel::download(new NilaiExport($tugas_id), 'nilai_tugas.xlsx');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

}
