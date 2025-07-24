<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $guruList = \App\Models\User::where('role', 'guru')->get();

        return view('kelas.create', compact('guruList'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'guru_id' => 'required|exists:users,id'
        ]);

        \App\Models\Kelas::create([
            'nama' => $request->nama,
            'guru_id' => $request->guru_id
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }


    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        $anggota = $kelas->users()->get();
        $semua_siswa = User::where('role', 'siswa')->get();

        return view('kelas.show', compact('kelas', 'anggota', 'semua_siswa'));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $guru = User::where('role', 'guru')->get(); // Ambil semua guru untuk dropdown
        return view('kelas.edit', compact('kelas', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->nama = $request->nama;
        $kelas->guru_id = $request->guru_id;
        $kelas->save();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function tambahSiswa(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $kelas->users()->syncWithoutDetaching([$request->user_id]);

        return back()->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function hapusSiswa(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->users()->detach($request->user_id);

        return back()->with('success', 'Siswa berhasil dihapus dari kelas.');
    }
}
