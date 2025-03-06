<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketersediaan extends Model
{
    use HasFactory;

    protected $table = 'ketersediaan';
    protected $fillable = ['user_id', 'grup_id', 'tanggal', 'waktu'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
