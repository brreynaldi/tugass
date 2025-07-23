<?php
namespace App\Http\Controllers;

use App\Models\Tugas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SemuaNilaiExport;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportSemuaNilai()
    {
        $user = Auth::user();

        if ($user->role !== 'guru') {
            abort(403, 'Akses ditolak.');
        }

        return Excel::download(new SemuaNilaiExport($user->id), 'semua_nilai.xlsx');
    }
}
