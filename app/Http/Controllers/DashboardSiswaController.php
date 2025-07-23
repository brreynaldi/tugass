<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();   // jika ingin statistik, ambil di sini
        return view('dashboard.siswa', compact('user'));
    }
}
