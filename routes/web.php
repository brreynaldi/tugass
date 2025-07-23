<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\QuizSoalController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\QuizJawabanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardSiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\BimbinganChatController;

// Redirect root URL ke login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route khusus wali
Route::middleware(['auth', 'role:wali'])->group(function () {
   Route::get('/dashboard', [WaliController::class, 'index'])->name('dashboard.wali');
    Route::get('/tugas/{id}', [WaliController::class, 'tugas'])->name('wali.tugas');
    Route::get('/wali/anak/{id}/quiz', [WaliController::class, 'quiz'])->name('wali.anak.quiz');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read.one');
});

Route::post('/tugas/{id}/forum', [ForumController::class, 'store'])->name('forum.store');


// Export
Route::get('/tugas/{id}/export-nilai', [TugasController::class, 'exportNilai'])->name('tugas.export');
Route::get('/export-nilai', [ExportController::class, 'exportSemuaNilai'])->name('tugas.export.semua');


// Semua user yang sudah login
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Users (Admin)
    Route::resource('users', UserController::class);

    // Manajemen Kelas
    Route::resource('kelas', KelasController::class);
    Route::post('/kelas/{id}/tambah-siswa', [KelasController::class, 'tambahSiswa'])->name('kelas.tambahSiswa');
    Route::post('/kelas/{id}/hapus-siswa', [KelasController::class, 'hapusSiswa'])->name('kelas.hapusSiswa');

    // Quiz dan Soal
    Route::resource('quiz', QuizController::class);
    Route::get('quiz/{quiz}/soal', [QuizSoalController::class, 'index'])->name('quiz.soal.index');
    Route::get('quiz/{quiz}/soal/create', [QuizSoalController::class, 'create'])->name('quiz.soal.create');
    Route::post('quiz/soal', [QuizSoalController::class, 'store'])->name('quiz.soal.store');
    Route::delete('quiz/soal/{id}', [QuizSoalController::class, 'destroy'])->name('quiz.soal.destroy');

    Route::get('quiz/{quiz}/kerjakan', [QuizJawabanController::class, 'kerjakan'])->name('quiz.kerjakan');
    Route::post('quiz/{quiz}/kerjakan', [QuizJawabanController::class, 'simpanJawaban'])->name('quiz.simpan');

    // Tugas
    Route::resource('tugas', TugasController::class);
    Route::get('/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');
    Route::post('/tugas/{id}/jawaban', [TugasController::class, 'storeJawaban'])->name('tugas.jawab');
    Route::get('/tugas/jawaban/{id}/nilai', [TugasController::class, 'nilaiForm'])->name('tugas.nilai.form');
    Route::post('/tugas/jawaban/{id}/nilai', [TugasController::class, 'nilaiSimpan'])->name('tugas.nilai.simpan');

    // Notifikasi umum
    Route::get('/notifikasi/baca', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifikasi.baca');
    Route::post('/notifikasi/baca', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifikasi.baca');

    Route::middleware('auth')->group(function(){
    Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/bimbingan/create', [BimbinganController::class, 'create'])->name('bimbingan.create');
    Route::post('/bimbingan', [BimbinganController::class, 'store'])->name('bimbingan.store');
    Route::post('/bimbingan/{id}/respon', [BimbinganController::class,'respon'])->name('bimbingan.respon');
    Route::post('/bimbingan/{id}/selesai',[BimbinganController::class, 'selesai'])->name('bimbingan.selesai');
    Route::post('/bimbingan/{id}/chat',[BimbinganController::class, 'chatStore'])->name('bimbingan.chat');
    Route::post('/bimbingan/{id}/terima', [BimbinganController::class, 'terima'])->name('bimbingan.terima');
    Route::post('/bimbingan/{id}/tolak', [BimbinganController::class, 'tolak'])->name('bimbingan.tolak');
    Route::get('/bimbingan/{id}/chat', [BimbinganController::class, 'chat'])->name('bimbingan.chat');
    Route::post('/bimbingan/{id}/chat', [BimbinganController::class, 'kirimChat'])->name('bimbingan.kirimChat');



    });

    Route::middleware(['auth', 'role:siswa'])->group(function () {
            Route::get('/dashboard-siswa', [DashboardSiswaController::class, 'index'])->name('dashboard.siswa');
        });

        Route::middleware(['auth', 'role:guru'])->group(function () {
            Route::get('/dashboard-guru', [DashboardController::class, 'index'])->name('dashboard.guru');
        });

        Route::middleware(['auth', 'role:wali'])->group(function () {
            Route::get('/dashboard-wali', [WaliController::class, 'index'])->name('dashboard.wali');
        });

        Route::get('/redirect-after-login', function () {
            $user = auth()->user();

            return match ($user->role) {
                'siswa' => redirect()->route('dashboard.siswa'),
                'guru' => redirect()->route('dashboard.guru'),
                'wali' => redirect()->route('dashboard.wali'),
                default => abort(403),
            };
        });
        
});
