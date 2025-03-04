<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaGrup extends Model
{
    use HasFactory;

    protected $table = 'anggota_grup';
    protected $primaryKey = 'id_anggota_grup';
    protected $fillable = ['grup_id', 'user_id', 'role'];

    public function grup()
    {
        return $this->belongsTo(Grup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
