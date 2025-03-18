<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    protected $fillable = ['vote_id', 'question', 'type', 'required'];
    
    public function vote()
    {
        return $this->belongsTo(vote::class);
    }
    public function options()
    {
        return $this->hasMany(option::class);
    }

    public function results()
    {
        return $this->hasMany(result::class);
    }
}
