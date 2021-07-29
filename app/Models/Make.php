<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Make extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = [];

    public function ebayItems()
    {
        return $this->hasMany(EbayItem::class);
    }

    public function alternatives()
    {
        return $this->morphMany(Alternative::class, 'alternate');
    }

    public function ebayCategory()
    {
        return $this->hasOne(EbayCategory::class);
    }
}
