<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'name',
        'close_date',
        'status',
        'result_visibility',
        'code',
        'slug'
    ];
    public function question()
    {
        return $this->hasMany(question::class);
    }
}
