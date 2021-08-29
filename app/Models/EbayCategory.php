<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class EbayCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll',
        'polled_at',
        'qty_received'
    ];

    protected $casts = [
        'poll' => 'boolean'
    ];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }
}
