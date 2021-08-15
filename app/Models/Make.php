<?php

namespace App\Models;

use App\Services\StaticService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Make extends Model
{
    use HasFactory, NodeTrait;

    private $staticService;

    protected $guarded = [];

    protected $appends = ['full_name', 'full_folder'];

    public function getFullNameAttribute()
    {
        $fullMake = self::ancestorsAndSelf($this->id)->sortBy('_lft');

        return $fullMake->reduce(function ($carry, $item) {
            return $carry .' '. $item->name;
        });
    }

    public function getFullFolderAttribute()
    {
        $fullMake = self::ancestorsAndSelf($this->id);
        return $fullMake->reduce(function ($carry, $item) {
            return $carry .'/'. $item->slug;
        });
    }

    public function ebayItems()
    {
        return $this->hasMany(EbayItem::class)->where('ended_at', '>', now()->subMonths(config('ebay.settings.usedMonths')))->orderBy('ended_at', 'DESC');
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
