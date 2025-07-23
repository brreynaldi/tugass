<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\ForumDiskusiBaru;

class ForumController extends Controller
{
    public function store(Request $request, $tugas_id)
{
    $request->validate([
        'pesan' => 'required|string|max:1000'
    ]);

    $forum = Forum::create([
        'user_id' => Auth::id(),
        'tugas_id' => $tugas_id,
        'pesan' => $request->pesan
    ]);

    $tugas = Tugas::with('kelas')->findOrFail($tugas_id);
    $pengirim = Auth::user();

    // Ambil semua siswa di kelas
    $siswaList = $tugas->kelas->users()->where('role', 'siswa')->get();

    // 🔹 Notifikasi ke guru, tapi JANGAN kirim jika pengirim adalah guru itu sendiri
    if ($tugas->guru && $tugas->guru->id !== $pengirim->id) {
        $tugas->guru->notify(new ForumDiskusiBaru($forum, $pengirim));
    }

    // 🔹 Notifikasi ke semua siswa & wali
    foreach ($siswaList as $siswa) {
        // Kirim ke siswa (kecuali pengirim)
        if ($siswa->id !== $pengirim->id) {
            $siswa->notify(new ForumDiskusiBaru($forum, $pengirim));
        }

        // Kirim ke walinya (kecuali pengirim)
        if ($siswa->wali && $siswa->wali->id !== $pengirim->id) {
            $siswa->wali->notify(new ForumDiskusiBaru($forum, $pengirim));
        }
    }

    return back()->with('success', 'Pesan forum berhasil dikirim dan notifikasi telah dikirim.');
}

}
