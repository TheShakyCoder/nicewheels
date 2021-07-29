<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EbayItemImage;
use Illuminate\Http\Request;

class CarImagesController extends Controller
{
    public function show(EbayItemImage $ebayItemImage)
    {
        return \Storage::disk('spaces')->temporaryUrl(
            config('filesystems.disks.spaces.folder').'/ebay-items/'.$ebayItemImage->ebay_item_id.'/'.$ebayItemImage->file,
            now()->addMinutes(60)
        );
    }
}
