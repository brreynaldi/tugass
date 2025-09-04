<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasJawaban extends Model
{
    use HasFactory;
    protected $table = 'tugas_jawaban';
    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'jawaban',
        'nilai' // jika kamu pakai penilaian,
    ];

    // Relasi (opsional)
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    /**
     * Relasi ke siswa (User dengan role siswa).
     */
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function jawaban()
    {
        return $this->hasMany(TugasJawaban::class, 'tugas_id');
    }
}