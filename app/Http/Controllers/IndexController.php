<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\EbayCategory;
use App\Models\EbayItem;
use App\Models\LocalMake;
use App\Models\Redemption;
use App\Services\EbayService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __invoke()
    {
        return redirect()->route('usedPrices');
    }
}
