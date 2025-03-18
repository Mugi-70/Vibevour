<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'open_date',
        'close_date',
        'status',
        'require_name',
        'result_visibility',
        'is_protected',
        'access_code',
    ];
    public function questions()
    {
        return $this->hasMany(question::class);
    }

    public function results()
    {
        return $this->hasMany(result::class);
    }
}
