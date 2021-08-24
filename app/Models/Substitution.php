<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substitution extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function make()
    {
        return $this->belongsTo(Make::class);
    }
    
    public function newMake()
    {
        return $this->belongsTo(Make::class, 'to_make_id');
    }
}
