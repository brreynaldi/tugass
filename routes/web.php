<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    KelasController,
    QuizController,
    TugasController,
    QuizSoalController,
    WaliController,
    QuizJawabanController,
    DashboardController,
    DashboardSiswaController,
    UserController,
    NotifikasiController,
    ExportController,
    ForumController,
    BimbinganController
};

// Redirect root URL ke login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

/*----------------------------------------------------------
| COMMON ROUTES (Semua user login)
----------------------------------------------------------*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Forum (semua user login)
    Route::post('/tugas/{id}/forum', [ForumController::class, 'store'])->name('forum.store');

    // Export nilai (admin/guru saja yang pakai logic di controller)
    Route::get('/tugas/{id}/export-nilai', [TugasController::class, 'exportNilai'])->name('tugas.export');
    Route::get('/export-nilai', [ExportController::class, 'exportSemuaNilai'])->name('tugas.export.semua');

    // Notifikasi umum
    Route::match(['get','post'], '/notifikasi/baca', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifikasi.baca');

Route::resource('kelas', KelasController::class);
Route::post('/kelas/{id}/tambah-siswa', [KelasController::class, 'tambahSiswa'])->name('kelas.tambahSiswa');
    Route::post('/kelas/{id}/hapus-siswa', [KelasController::class, 'hapusSiswa'])->name('kelas.hapusSiswa');

    // Bimbingan (semua user login)
    Route::prefix('bimbingan')->group(function () {
        Route::get('/', [BimbinganController::class, 'index'])->name('bimbingan.index');
        Route::get('/create', [BimbinganController::class, 'create'])->name('bimbingan.create');
        Route::post('/', [BimbinganController::class, 'store'])->name('bimbingan.store');
        Route::post('/{id}/respon', [BimbinganController::class,'respon'])->name('bimbingan.respon');
        Route::post('/{id}/selesai',[BimbinganController::class, 'selesai'])->name('bimbingan.selesai');
        Route::post('/{id}/terima', [BimbinganController::class, 'terima'])->name('bimbingan.terima');
        Route::post('/{id}/tolak', [BimbinganController::class, 'tolak'])->name('bimbingan.tolak');
        Route::get('/{id}/chat', [BimbinganController::class, 'chat'])->name('bimbingan.chat');
        Route::post('/{id}/chat', [BimbinganController::class, 'kirimChat'])->name('bimbingan.kirimChat');
    });

    // Semua role bisa lihat daftar tugas sesuai role-nya
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/tugas/{id}', [TugasController::class, 'show'])
        ->name('siswa.tugas.show');
});



/*----------------------------------------------------------
| ADMIN ROUTES
----------------------------------------------------------*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
   });
Route::post('/kelas/{id}/hapus-siswa-batch', [KelasController::class, 'hapusSiswaBatch'])->name('kelas.hapusSiswaBatch');

/*----------------------------------------------------------
| GURU ROUTES
----------------------------------------------------------*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.guru');

    // CRUD Tugas (hanya guru)
    Route::resource('tugas', TugasController::class)->except(['index']);
    Route::post('/tugas/{id}/jawaban', [TugasController::class, 'storeJawaban'])->name('tugas.jawab');
    Route::get('/tugas/jawaban/{id}/nilai', [TugasController::class, 'nilaiForm'])->name('tugas.nilai.form');
    Route::post('/tugas/jawaban/{id}/nilai', [TugasController::class, 'nilaiSimpan'])->name('tugas.nilai.simpan');

    // Kelas
    
    // Quiz
    Route::resource('quiz', QuizController::class);
    Route::get('quiz/{quiz}/soal', [QuizSoalController::class, 'index'])->name('quiz.soal.index');
    Route::get('quiz/{quiz}/soal/create', [QuizSoalController::class, 'create'])->name('quiz.soal.create');
    Route::post('quiz/soal', [QuizSoalController::class, 'store'])->name('quiz.soal.store');
    Route::delete('quiz/soal/{id}', [QuizSoalController::class, 'destroy'])->name('quiz.soal.destroy');
});

/*----------------------------------------------------------
| SISWA ROUTES
----------------------------------------------------------*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard.siswa');

    // Kerjakan Quiz
    Route::get('quiz/{quiz}/kerjakan', [QuizJawabanController::class, 'kerjakan'])->name('quiz.kerjakan');
    Route::post('quiz/{quiz}/kerjakan', [QuizJawabanController::class, 'simpanJawaban'])->name('quiz.simpan');
   
    // Jawab tugas
    Route::post('/tugas/{id}/jawaban', [TugasController::class, 'storeJawaban'])->name('tugas.jawab');
});

/*----------------------------------------------------------
| WALI ROUTES
----------------------------------------------------------*/
Route::middleware(['auth', 'role:wali'])->prefix('wali')->group(function () {
    Route::get('/dashboard', [WaliController::class, 'index'])->name('dashboard.wali');
    Route::get('/tugas/{id}', [WaliController::class, 'tugas'])->name('wali.tugas');
    Route::get('/anak/{id}/quiz', [WaliController::class, 'quiz'])->name('wali.anak.quiz');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read.one');
});

/*----------------------------------------------------------
| REDIRECT SETELAH LOGIN
----------------------------------------------------------*/
Route::get('/redirect-after-login', function () {
    $user = auth()->user();

    return match ($user->role) {
        'siswa' => redirect()->route('dashboard.siswa'),
        'guru' => redirect()->route('dashboard.guru'),
        'wali' => redirect()->route('dashboard.wali'),
        'admin' => redirect()->route('dashboard'),
        default => abort(403),
    };
});
