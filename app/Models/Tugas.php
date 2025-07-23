<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
     protected $fillable = [
        'judul',
        'deskripsi',
        'file',
        'kelas_id',
        'guru_id',
        'tanggal_deadline'
    ];
    use HasFactory;
    public function kelas()
{
    return $this->belongsTo(Kelas::class, 'kelas_id');
}

public function guru()
{
    return $this->belongsTo(User::class, 'guru_id');
}
public function forums() {
    return $this->hasMany(Forum::class);
}


}
