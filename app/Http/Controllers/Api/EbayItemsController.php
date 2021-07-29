<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EbayItem;
use App\Models\Make;
use App\Services\EbayItemService;
use Illuminate\Http\Request;

class EbayItemsController extends Controller
{
    public function show(EbayItem $ebayItem)
    {
        $make = Make::ancestorsAndSelf($ebayItem->make_id);

        return response()->json([
            'ebayItem' => $ebayItem,
            'make' => $make
        ]);
    }

    public function bookmark(Request $request, EbayItemService $ebayItemService, EbayItem $ebayItem)
    {
        return response()->json([
            'bookmark' => $ebayItem,
            'action' => $ebayItemService->bookmark($request->user(), $ebayItem)
        ], 200);
    }

    public function myCars(EbayItemService $ebayItemService, Request $request)
    {
        $ids = $request->get('ids');

        $myBookmarks = $ebayItemService->getMyBookmarks($request->user(), $ids);
        $myRedemptions = $ebayItemService->getMyRedemptions($request->user(), $ids);

        return response()->json([
            'request' => $request->all(),
            'myBookmarks' => $myBookmarks,
            'myRedemptions' => $myRedemptions
        ], 200);
    }

    public function redeem(EbayItem $ebayItem, Request $request)
    {
        $auth = $request->user();

        $auth->refresh();
        if($auth->tokens <= 0) {
            return redirect()->back();
        }

        $transaction = $auth->transactions()->where('remaining', '>', 0)->first();
        $transaction->remaining = $transaction->remaining - 1;
        $transaction->save();

        $auth->redemptions()->create([
            'ebay_item_id' => $ebayItem->id,
            'amount' => $ebayItem->final_amount,
            'transaction_id' => $transaction->id
        ]);

        $ebayItem = EbayItem::query()->where('id', $ebayItem->id)
            ->with(['redemptions'])
            ->whereHas('redemptions', function($q2) use($auth) {
                $q2->where('user_id', $auth->id);
            })
            ->first();

        $auth->refresh();
        return response()->json([
            'user' => $auth,
            'redemption' => $ebayItem
        ], 200);
    }
}
