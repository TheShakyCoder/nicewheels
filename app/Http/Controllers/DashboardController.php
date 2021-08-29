<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\EbayItem;
use App\Models\Transaction;
use App\Services\EbayItemService;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard (Request $request)
    {
        $user = $request->user();

        $latestBookmarks = Bookmark::query()
            ->where('user_id', $user->id)
            ->limit(3)
            ->orderBy('created_at', 'DESC')
            ->pluck('ebay_item_id')
            ;

        $bookmarks = EbayItem::query()
            ->whereHas('bookmarks', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->whereIn('id', $latestBookmarks)
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->paginate(3);

        $redemptions = EbayItem::query()
            ->whereHas('redemptions', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->paginate(3);

        return Inertia::render('Dashboard', [
            'bookmarks' => $bookmarks,
            'redemptions' => $redemptions
        ]);
    }

    public function purchases (Request $request)
    {
        $transactions = Transaction::query()
            ->where('user_id', $request->user()->id)
            ->get();

        return Inertia::render('Purchases', [
            'transactions' => $transactions
        ]);
    }

    public function redemptions (Request $request)
    {
        $user = $request->user();

        $redemptions = EbayItem::query()
            ->whereHas('redemptions', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->paginate(12);

        return Inertia::render('Redemptions', [
            'redemptions' => $redemptions,
        ]);
    }

    public function bookmarks (Request $request)
    {
        $user = $request->user();

        $bookmarks = EbayItem::query()
            ->whereHas('bookmarks', function($q2) use($user) {
                $q2->where('user_id', $user->id);
            })
            ->with(['bookmarks', 'redemptions'])
            ->without(['images'])
            ->paginate(12);

        return Inertia::render('Bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
