<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    public function alternatives()
    {
        return $this->morphMany(Alternative::class, 'alternate');
    }

    public function ebayItems()
    {
        return $this->belongsToMany(EbayItem::class, 'ebay_items_filters');
    }
}
