<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbayAspect extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ebayItem()
    {
        return $this->belongsTo(EbayItem::class);
    }
}
