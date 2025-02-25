<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class option extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'option'];
    
    public function question()
    {
        return $this->belongsTo(question::class);
    }
}
