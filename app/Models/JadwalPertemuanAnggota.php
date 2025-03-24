<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPertemuanAnggota extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pertemuan_anggota';
    protected $fillable = ['jadwal_id', 'user_id', 'grup_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPertemuan::class, 'jadwal_id');
    }

    public function anggota()
    {
        return $this->hasMany(JadwalPertemuanAnggota::class, 'jadwal_id');
    }
}
