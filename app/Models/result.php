<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class result extends Model
{
    use HasFactory;

    protected $fillable = [
        'vote_id',
        'question_id',
        'option_id',
        'name'
    ];
    
    public function vote()
    {
        return $this->belongsTo(vote::class);
    }

    public function question()
    {
        return $this->belongsTo(question::class);
    }

    public function option()
    {
        return $this->belongsTo(option::class);
    }
}
