<?php

namespace App\Http\Controllers;

use App\Models\EbayItem;
use App\Services\EbayItemService;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard (EbayItemService $ebayItemService)
    {
        $bookmarks = $ebayItemService->getMyBookmarks(\Auth::user(), null, 3);
        $redemptions = $ebayItemService->getMyRedemptions(\Auth::user(), null, 3);

        return Inertia::render('Dashboard', [
            'bookmarks' => $bookmarks,
            'redemptions' => $redemptions
        ]);
    }

    public function purchase ()
    {
        return Inertia::render('Purchase');
    }

    public function redemptions (EbayItemService $ebayItemService, NewsService $newsService)
    {
        $cars = $ebayItemService->getRecentlyRedeemed(\Auth::id(), 12);
        $news = $newsService->feed(6);

        return Inertia::render('Redemptions', [
            'cars' => $cars,
            'news' => $news
        ]);
    }

    public function bookmarks (EbayItemService $ebayItemService, NewsService $newsService)
    {
        $cars = $ebayItemService->getRecentlyBookmarked(\Auth::id(), 12);
        $news = $newsService->feed(6);

        return Inertia::render('Bookmarks', [
            'cars' => $cars,
            'news' => $news
        ]);
    }
}
