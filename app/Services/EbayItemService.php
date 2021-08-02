<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\EbayAspect;
use App\Models\EbayCategory;
use App\Models\EbayItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EbayItemService
{
    public function createItemsFromJson(EbayCategory $ebayCategory, $json)
    {
        $count = 0;
        if(!isset($json->findItemsByCategoryResponse[0]->searchResult[0]->item)) {
            return 0;
        }
        foreach($json->findItemsByCategoryResponse[0]->searchResult[0]->item as $item) {
            //  items to remove
            $isUsed = 1;
            $keywords = collect(config('ebay.keywords.item_not_used'));
            foreach($keywords as $e) {
                if(strpos(strtolower($item->title[0]), strtolower($e)) !== false) {
                    $isUsed = 0;
                    break;
                }
                if(isset($item->subtitle) && strpos(strtolower($item->subtitle[0]), strtolower($e)) !== false) {
                    $isUsed = 0;
                    break;
                }
            }

            //  words to remove
            $title    = addcslashes($item->title[0], '()');
            $subtitle = isset($item->subtitle) ? $item->subtitle[0] : null;
            foreach(config('ebay.keywords.to_remove') as $phrase) {
                $title    = str_ireplace($phrase, '', $title);
                $subtitle = str_ireplace($phrase, '', $subtitle);
            }
            $title    = trim($title);
            $subtitle = trim($subtitle);

            EbayItem::query()->updateOrCreate([
                'ebay_item_id' => $item->itemId[0]
            ], [
                'ebay_category_id' => $ebayCategory->id,
                'title' => $title,
                'subtitle' => $subtitle,
                'primary_category_id' => $item->primaryCategory[0]->categoryId[0],
                'ebay_url' => $item->viewItemURL[0],
                'gallery_url' => isset($item->galleryURL[0]) ? $item->galleryURL[0] : null,
                'bids' => $item->sellingStatus[0]->bidCount[0],
                'used_price' => $isUsed,
                'make_id' => $ebayCategory->make_id,
                'final_amount' => $item->sellingStatus[0]->convertedCurrentPrice[0]->__value__,
                'ended_at' => (new \DateTime($item->listingInfo[0]->endTime[0]))->format('Y-m-d H:i:s')
            ]);
            $count++;
        }
        return $count;
    }

    public function patchItemsFromJson($json)
    {
        $iteration = 0;
        foreach($json->Item as $item) {
            $iteration++;
            if($ebayItem = $this->patchItemFromJson($item)) {
                // images
                $iterationImage = 0;
                foreach($item->PictureURL as $image) {
                    if($this->fetchImage($image, $ebayItem, $iterationImage)) {
                        $iterationImage++;
                    }
                }
                // aspects
                if(isset($item->ItemSpecifics)) {
                    $this->patchAspectsFromJson($ebayItem, $item->ItemSpecifics->NameValueList);
                }
            }
        }
        return $iteration;
    }

    public function patchItemFromJson($item)
    {
        $patch = [
            'bids' => $item->BidCount,
            'final_amount' => $item->ConvertedCurrentPrice->Value,
            'aspected_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ];
        $ebayItem = EbayItem::where('ebay_item_id', $item->ItemID)->first();
        $ebayItem->fill($patch);
        $ebayItem->save();
        return $ebayItem;
    }

    public function fetchImage($image, EbayItem $ebayItem, $sort)
    {
        if($this->get_http_response_code($image) != "200") {
            exit;
        }
//        echo 'PROCESSING IMAGE'.PHP_EOL;
        try {
            $ch = curl_init();
            $timeout = 10;

            curl_setopt($ch, CURLOPT_URL, $image);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            $content = curl_exec($ch);
            curl_close($ch);
        } catch(\ErrorException $e) {
            echo 'PROCESSING IMAGE ERROR: '.$e->getMessage().PHP_EOL;
            return 0;
        }

        $size = getimagesize($image);
        $extension = image_type_to_extension($size[2]);
        if($extension == '') {
            echo 'NO EXT: '.$e->getMessage().PHP_EOL;
            return 0;
        }

        $name = (string)\Uuid::generate(4).$extension;
        try {
            if(Storage::disk('spaces')->put(config('filesystems.disks.spaces.folder').'/ebay-items/'.$ebayItem->id.'/'.$name, $content)) {
                $ebayItem->images()->create([
                    'original_url' => $image,
                    'file' => $name,
                    'sort' => $sort
                ]);
            }
        } catch (\Exception $e) {
            echo 'CANNOT SAVE: '.$e->getMessage().PHP_EOL;
            $ebayItem->images()->create([
                'original_url' => $image,
            ]);
        }
        return 1;
    }

    public function patchAspectsFromJson($ebayItem, $json)
    {
        $year = null;
        $mileage = null;
        foreach($json as $nameValue) {
            if($nameValue->Name == 'Mileage') {
                $mileage = $nameValue->Value[0];
            }
            if($nameValue->Name == 'Year') {
                $year = $nameValue->Value[0];
            }
            $ebayItem->aspects()->firstOrCreate(['ebay_item_id' => $ebayItem->id, 'name' => $nameValue->Name], ['value' => $nameValue->Value[0], 'processed_at' => now()]);
        }
        $ebayItem->mileage = $mileage;
        $ebayItem->year = $year;
        $ebayItem->processed_at = now();
        if($mileage == null || $year == null) {
            $ebayItem->used_price = 0;
        }
        $ebayItem->save();
    }

    public function checkForErrors($json)
    {
        if(isset($json->Errors)) {
            if($json->Errors[0]->ErrorCode == '10.12' || $json->Errors[0]->ErrorCode == '10.15') {
                echo 'The following EbayItems have been removed:'.PHP_EOL;
                echo $json->Errors[0]->ErrorParameters[0]->Value.PHP_EOL;
                EbayItem::query()->whereIn('ebay_item_id', explode(',', $json->Errors[0]->ErrorParameters[0]->Value))->delete();
                EbayAspect::query()->whereIn('ebay_item_id', explode(',', $json->Errors[0]->ErrorParameters[0]->Value))->delete();
            }
        }
    }

    public function bookmark(User $user, EbayItem $ebayItem)
    {
        if($user->bookmarks()->where('ebay_item_id', $ebayItem->id)->exists()) {
            $action = 'delete';
            $user->bookmarks()->where('ebay_item_id', $ebayItem->id)->delete();
        } else {
            $user->bookmarks()->create([
                'ebay_item_id' => $ebayItem->id
            ]);
            $action = 'create';
        }

        return $action;
    }

    public function getRecentlyRedeemed($userId, $paginate)
    {
        $redemptions = \DB::table('redemptions')
            ->select(['ebay_item_id'])
            ->where('user_id', $userId)
            ->pluck('ebay_item_id')
            ;

        $query = $this->rootQuery($redemptions, $paginate, null, null, $userId);

        return $query;
    }

    public function getRecentlyBookmarked($userId, $paginate)
    {
        $bookmarks = \DB::table('bookmarks')
            ->select(['ebay_item_id'])
            ->where('user_id', $userId)
            ->pluck('ebay_item_id')
            ;

        $query = $this->rootQuery($bookmarks, $paginate, null, null, $userId);

        return $query;
    }

    public function getMyBookmarks(User $user, Array $ids)
    {
        return EbayItem::query()
            ->whereIn('id', $ids)
            ->whereHas('bookmarks', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })->get();
    }

    public function getMyRedemptions(User $user, Array $ids)
    {
        return EbayItem::query()
            ->whereIn('id', $ids)
            ->with(['redemptions'])
            ->whereHas('redemptions', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })->get();
    }

    /**
     * @param int $userId
     * @param int $limit
     * @return false|string
     */
    public function getPublicEbayItems($userId = 0, $paginate = 12, $search = null, $filterMakes = null, $make = null, $exclude = null)
    {
        $query = $this->rootQuery(null, $exclude, $paginate, $search, $filterMakes, $userId);
        $query->appends([
            'search' => $search,
            'make' => $make,
        ]);

        return $query;
    }

    /**
     * @param null $include
     * @param null $exclude
     * @param int $paginate
     * @param null $search
     * @param null $filterMakes
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function rootQuery($include = null, $exclude = null, $paginate = 12, $search = null, $filterMakes = null, $userId = 0)
    {
        return EbayItem::query()
            ->with(['make', 'images' => function($q) {
                $q->orderBy('sort', 'ASC');
            }, 'aspects'])
            ->when($include, function($q) use($include) {
                $q->whereIn('id', $include);
            })
            ->when($exclude, function($q) use($exclude) {
                $q->whereNotIn('id', $exclude);
            })
            ->when($userId, function($q) use($userId) {
                $q->with(['bookmarks' => function($q2) use($userId) {
                    $q2->where('user_id', $userId);
                }, 'redemptions' => function($q2) use($userId) {
                    $q2->where('user_id', $userId);
                }]);
            })
            ->where('used_price', 1)
            ->whereNotNull('processed_at')
            ->whereBetween('ended_at', [now()->subMonths(6), now()])
            ->when($search, function($q) use($search) {
                $q->where('title', 'LIKE', '%'.$search.'%')->orWhere('subtitle', 'LIKE', '%'.$search.'%');
            })
            ->when($filterMakes, function($q) use($filterMakes) {
                $q->whereIn('make_id', $filterMakes->pluck§('id'));
            })
            ->orderBy('ended_at', 'DESC')
            ->paginate($paginate)
            ;
    }


    private function get_http_response_code ($url)
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
}
