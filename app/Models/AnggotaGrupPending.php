<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaGrupPending extends Model
{
    use HasFactory;

    protected $table = 'anggota_grup_pending';
    protected $fillable = ['grup_id', 'email', 'status'];
}
