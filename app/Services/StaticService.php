<?php

namespace App\Services;

use App\Models\EbayItem;
use App\Models\Make;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class StaticService
{
    public function getFolder(Collection $fullMake)
    {
        return $fullMake->reduce(function ($carry, $item) {
            return $carry .'/'. $item->slug;
        });
    }

    public function getFilterCompiledHtml($template, $fullMake, $cars, $lastPage, $makeAndDescendants, $makes, $folder, $news)
    {
        return view($template, [
            'fullMake' => $fullMake,
            'cars' => $cars,
            'lastPage' => $lastPage,
            'makesAndDescendants' => $makeAndDescendants,
            'makes' => $makes,
            'folder' => $folder,
            'news' => $news
        ])->render();
    }

    public function getCarCompiledHtml($template, $car, $makes)
    {
        return view($template, [
            'car' => $car,
            'makes' => $makes
        ])->render();
    }

    public function getMyBookmarks(User $user, Array $ids = null, $limit = 12)
    {
        return EbayItem::query()
            ->when($ids, function($q) use($ids) {
                $q->whereIn('id', $ids);
            })
            ->whereHas('bookmarks', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->limit($limit)
            ->get()
            ;
    }

    public function getMyRedemptions(User $user, Array $ids = null, $limit = 12)
    {
        return EbayItem::query()
            ->when($ids, function($q) use($ids) {
                $q->whereIn('id', $ids);
            })
            ->whereHas('redemptions', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->limit($limit)
            ->get()
            ;
    }
}
