<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'guru_id'];

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'kelas_user');
    }
    // app/Models/Kelas.php

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'kelas_user', 'kelas_id', 'user_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

}
