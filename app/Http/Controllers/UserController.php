<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
          $waliList = User::where('role', 'wali')->get(); // ambil semua wali
    return view('users.create', compact('waliList'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,guru,siswa,wali',
        'wali_id' => 'nullable|exists:users,id' // hanya untuk siswa
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ];

    // Jika siswa, simpan wali_id
    if ($request->role === 'siswa') {
        $data['wali_id'] = $request->wali_id;
    }

    User::create($data);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
}

    public function edit(User $user)
    {
        $waliList = User::where('role', 'wali')->get(); // untuk siswa memilih wali
        return view('users.edit', compact('user', 'waliList'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,guru,siswa,wali',
            'wali_id' => 'nullable|exists:users,id'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Update wali_id jika role adalah siswa
        if ($request->role === 'siswa') {
        $data['wali_id'] = $request->wali_id;
    }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
