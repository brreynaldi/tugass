<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $fillable = ['siswa_id', 'guru_id', 'wali_id', 'pesan'];
     protected $table = 'bimbingan';
    public function siswa() {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function wali() {
        return $this->belongsTo(User::class, 'wali_id');
    }
    public function chat()
    {
        return $this->hasMany(BimbinganChat::class);
    }
}