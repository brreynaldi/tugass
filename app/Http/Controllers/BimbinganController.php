<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Bimbingan;
use App\Models\BimbinganChat;
use App\Notifications\PermintaanBimbinganBaru;
use App\Notifications\ResponBimbinganDariGuru;
use App\Notifications\ChatBimbinganBaru;

class BimbinganController extends Controller {
  public function index()
    {
        $user = Auth::user();

        $bimbingans = Bimbingan::where('siswa_id', $user->id)
            ->orWhere('guru_id', $user->id)
            ->orWhere('wali_id', $user->id)
            ->with(['siswa', 'guru', 'wali'])
            ->get();

        return view('bimbingan.index', compact('bimbingans'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->get();

        if (auth()->user()->role === 'wali') {
            $siswas = User::where('wali_id', auth()->id())->get(); // siswa yang diampu wali ini
        } else {
            $siswas = collect(); // kosong kalau bukan wali
        }

        return view('bimbingan.create', compact('gurus', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
        ]);

        $user = Auth::user();

        $data = [
            'guru_id' => $request->guru_id,
            'pesan' => $request->pesan,
            'status' => 'menunggu',
        ];

        if ($user->role === 'siswa') {
            $data['siswa_id'] = $user->id;
            if (!is_null($user->wali_id)) {
                $data['wali_id'] = $user->wali_id;
            }
        } elseif ($user->role === 'wali') {
            $request->validate([
                'siswa_id' => 'required|exists:users,id',
            ]);

            $data['wali_id'] = $user->id;
            $data['siswa_id'] = $request->siswa_id;
        }

        $bimbingan = Bimbingan::create($data);

        // Notifikasi
        User::find($data['guru_id'])->notify(new PermintaanBimbinganBaru($bimbingan));

        return redirect()->route('bimbingan.index')->with('success', 'Permintaan bimbingan berhasil dikirim.');
    }



  public function ajukan(Request $req) {
    $v = $req->validate(['siswa_id'=>'required|exists:users,id','guru_id'=>'required|exists:users,id','pesan'=>'required']);
    $v['wali_id'] = auth()->id(); $v['status']='menunggu';
    $b = Bimbingan::create($v);
    User::find($v['guru_id'])->notify(new PermintaanBimbinganBaru($b));
    return back()->with('success','Telah meminta bimbingan.');
  }

  public function respon(Request $req,$id) {
    $status = $req->action=='setuju'?'disetujui':'ditolak';
    $b = Bimbingan::findOrFail($id);
    if (auth()->id() !== $b->guru_id) abort(403);
    $b->update(['status'=>$status]);
    $b->wali->notify(new ResponBimbinganDariGuru($b));
    return back()->with('success','Respon dikirim.');
  }

  public function chatStore(Request $r, $id)
{
    $r->validate(['message' => 'required|string']);
    $b = Bimbingan::findOrFail($id);
    if (!in_array(auth()->id(), [$b->wali_id, $b->guru_id])) abort(403);

    $chat = BimbinganChat::create([
        'bimbingan_id' => $id,
        'sender_id' => auth()->id(),
        'message' => $r->message,
    ]);

    // Notifikasi ke pihak lain
    $target = auth()->id() == $b->wali_id ? $b->guru : $b->wali;
    if ($target) {
        $target->notify(new ChatBimbinganBaru($b, $r->message));
    }

    return back();
}

public function terima($id)
{
    $bimbingan = Bimbingan::findOrFail($id);
    if (auth()->id() != $bimbingan->guru_id) abort(403);

    $bimbingan->update(['status' => 'diterima']);
    return back()->with('success', 'Bimbingan diterima.');
}

public function tolak($id)
{
    $bimbingan = Bimbingan::findOrFail($id);
    if (auth()->id() != $bimbingan->guru_id) abort(403);

    $bimbingan->update(['status' => 'ditolak']);
    return back()->with('success', 'Bimbingan ditolak.');
}

public function chat($id)
{
    $bimbingan = Bimbingan::findOrFail($id);

    // cek hak akses (guru, wali, atau siswa yang terkait)
    if (!in_array(auth()->id(), [$bimbingan->guru_id, $bimbingan->siswa_id, $bimbingan->wali_id])) {
        abort(403, 'Anda tidak memiliki akses.');
    }

    return view('bimbingan.chat', compact('bimbingan'));
}

public function selesai($id)
{
    $bimbingan = Bimbingan::findOrFail($id);
    $bimbingan->status = 'selesai';
    $bimbingan->save();

    return redirect()->back()->with('success', 'Bimbingan selesai.');
}

public function kirimChat(Request $request, $id)
{
    $bimbingan = Bimbingan::findOrFail($id);

    $chat = new BimbinganChat();
    $chat->bimbingan_id = $bimbingan->id;
    $chat->sender_id = auth()->id();
    $chat->message = $request->message;
    $chat->save();

    // Kirim notifikasi ke guru dan wali (kecuali pengirim sendiri)
    foreach ([$bimbingan->guru, $bimbingan->wali] as $user) {
        if ($user->id != auth()->id()) {
            $user->notify(new ChatBimbinganBaru($chat));
        }
    }

    return back();
}

}