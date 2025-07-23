<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Quiz;
use App\Models\Tugas;

class DashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();
    $data = [];

    if ($user->role == 'admin') {
        $data['total_users'] = User::count();
        $data['total_kelas'] = Kelas::count();
    } elseif ($user->role == 'guru') {
        $data['kelas'] = $user->kelas;
       
        $data['tugas'] = Tugas::where('guru_id', $user->id)->get();
    } elseif ($user->role == 'siswa'){
        $data['kelas'] = $user->kelas;
        $data['tugas'] = Tugas::whereIn('kelas_id', $user->kelas->pluck('id'))->get();
    } else {
        $data['kelas'] = $user->kelas;
        $data['tugas'] = Tugas::whereIn('wali_id', $user->kelas->pluck('id'))->get();
    }

    return view('dashboard.index', compact('user', 'data'));
}

}
