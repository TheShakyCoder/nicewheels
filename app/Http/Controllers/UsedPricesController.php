<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\EbayItem;
use App\Models\Make;
use App\Models\Redemption;
use App\Services\EbayItemService;
use App\Services\EbayService;
use App\Services\NewsService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsedPricesController extends Controller
{
    public function __invoke(UserService $userService, EbayItemService $ebayItemService, NewsService $newsService)
    {
        $imagePath = config('filesystems.disks.nicewheels.path');

        $recentlyBookmarked = collect([]);
        $recentlyRedeemed = collect([]);
        $recentlyAdded = $ebayItemService->getPublicEbayItems(\Auth::check() ? \Auth::id() : 0, \Auth::check() ? 3 : 6);

        if(\Auth::check()) {
            $bookmarks = $userService->bookmarks()->count();
            $redemptions = $userService->redemptions()->count();

            $recentlyBookmarked = $ebayItemService->getRecentlyBookmarked(\Auth::id(), 3);
            $recentlyRedeemed = $ebayItemService->getRecentlyRedeemed(\Auth::id(), 3);
        }

        $news = $newsService->feed(\Auth::check() ? 8 : 3);

        return Inertia::render('UsedPrices/Summary', [
            'imagePath' => $imagePath,
            'bookmarks' => $bookmarks ?? 0,
            'redemptions' => $redemptions ?? 0,
            'news' => $news,
            'recentlyBookmarked' => $recentlyBookmarked,
            'recentlyRedeemed' => $recentlyRedeemed,
            'recentlyAdded' => $recentlyAdded
        ]);
    }

    public function filter(Request $request, EbayItemService $ebayItemService)
    {
        $make   = $request->get('make', null);
        $search = $request->get('search', null);

        $filterMakes = Make::descendantsAndSelf(
            Make::query()->where('slug', $make)->pluck('id')->toArray()
        )->pluck('id')->toArray();

        $cars = $ebayItemService->getPublicEbayItems(\Auth::check() ? \Auth::id() : 0, 6, $search, $filterMakes, $make);

        return Inertia::render('UsedPrices/Filter', [
            'cars' => $cars
        ]);

    }
}
