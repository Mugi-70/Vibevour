<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaJadwal extends Model
{
    use HasFactory;

    protected $table = 'peserta_jadwal';
    protected $fillable = ['grup_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPertemuan::class, 'jadwal_id');
    }
}
