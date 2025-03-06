<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'option', 'image'];
    
    public function questions()
    {
        return $this->belongsTo(question::class);
    }

    public function results()
    {
        return $this->hasMany(result::class);
    }
}
