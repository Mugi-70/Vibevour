<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPertemuan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pertemuan';
    protected $fillable = ['grup_id', 'judul', 'tanggal', 'waktu_mulai', 'durasi'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id');
    }

    public function peserta()
    {
        return $this->hasMany(JadwalPertemuanAnggota::class, 'jadwal_id');
    }
}
