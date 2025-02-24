<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_grup';
    protected $table = 'table__grup';
    protected $fillable = [
        'nama',
        'deskripsi',
        'durasi',
        'waktu_mulai',
        'waktu_selesai',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
}
