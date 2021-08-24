<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\EbayItemImage;

class CarImagesController extends Controller
{
    public function show(EbayItemImage $ebayItemImage)
    {
        // $image = \Storage::disk('spaces')->temporaryUrl(
        //     config('filesystems.disks.spaces.folder').'/ebay-items/'.$ebayItemImage->ebay_item_id.'/'.$ebayItemImage->file,
        //     now()->addMinutes(60)
        // );
                
        $hours = 24;

        $value = Cache::remember('image-'.$ebayItemImage->id, 3600 * $hours, function () use ($hours, $ebayItemImage) {
            return \Storage::disk('spaces')->temporaryUrl(
                config('filesystems.disks.spaces.folder').'/ebay-items/'.$ebayItemImage->ebay_item_id.'/'.$ebayItemImage->file,
                now()->addMinutes(60)
            ); 
        });

        return $value;

        // return \Storage::disk('spaces')->temporaryUrl(
        //     config('filesystems.disks.spaces.folder').'/ebay-items/'.$ebayItemImage->ebay_item_id.'/'.$ebayItemImage->file,
        //     now()->addMinutes(60)
        // );
    }
}
