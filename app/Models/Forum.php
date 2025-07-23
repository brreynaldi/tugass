<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['user_id', 'tugas_id', 'pesan'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tugas() {
        return $this->belongsTo(Tugas::class);
    }
}
