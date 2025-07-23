<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimbinganChat extends Model
{
    protected $fillable = ['bimbingan_id', 'sender_id', 'message'];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function bimbingan()
{
    return $this->belongsTo(Bimbingan::class);
}
public function pengirim()
{
    return $this->belongsTo(User::class, 'sender_id');
}
}
