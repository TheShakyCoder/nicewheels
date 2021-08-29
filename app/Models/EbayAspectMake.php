<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbayAspectMake extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'ebay_aspects_makes';

    public function make()
    {
        return $this->belongsTo(Make::class);
    }
}
