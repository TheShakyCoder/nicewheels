<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class EbayItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'final_amount'
    ];

    protected $appends = [
        'image',
        'slug'
    ];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function images()
    {
        return $this->hasMany(EbayItemImage::class);
    }

    public function aspects()
    {
        return $this->hasMany(EbayAspect::class);
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class, 'ebay_items_filters');
    }

    public function ebayCategory() {
        return $this->belongsTo(EbayCategory::class);
    }

    public function primaryCategory() {
        return $this->belongsTo(EbayCategory::class, 'primary_category_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function getImageAttribute()
    {
        if($this->has('images')) {
            return $this->images->first();
        }
    }

    public function getSlugAttribute()
    {
        return $this->id.'-'.Str::slug($this->title, '-');
    }

    public function scopePublic($query)
    {
        return $query
            ->where('used_price', true)
            ->whereHas('images')
            ->whereNotNull('processed_at')
            ->whereBetween('ended_at', [now()->subMonths(6), now()])
            ;
    }
}
