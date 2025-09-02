<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
        protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'wali_id',
        'anak_id' // kalau dipakai
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
       // app/Models/User.php
    // Untuk guru
    public function kelasDibuat()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
    // Untuk siswa
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_user', 'user_id', 'kelas_id');
    }
    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'wali_id','siswa_id');
    }
    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }
    
    public function bimbinganChats()
    {
        return $this->hasMany(BimbinganChat::class, 'sender_id');
    }

    // Wali memiliki banyak siswa
    public function anak()
    {
        return $this->hasMany(User::class, 'wali_id');
    }
    

}
