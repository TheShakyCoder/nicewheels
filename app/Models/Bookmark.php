<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'ebay_item_id'
    ];

    public function ebayItem()
    {
        return $this->belongsTo(EbayItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
