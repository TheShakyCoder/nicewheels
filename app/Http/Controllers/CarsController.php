<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\EbayItem;
use App\Models\Make;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filterMakes = Make::descendantsAndSelf(
            Make::query()->where('slug', $request->get('make', null))->pluck('id')->toArray()
        )->pluck('id')->toArray();

        $search = $request->get('search', null);

        $cars = EbayItem::query()
            ->whereHas('images')
            ->with(['bookmarks', 'redemptions', 'images'])
            ->when($filterMakes, function($q) use($filterMakes) {
                $q->whereIn('make_id', $filterMakes);
            })
            ->when($search, function($q) use($search) {
                $q->where('title', 'LIKE', '%'.$search.'%')->orWhere('subtitle', 'LIKE', '%'.$search.'%');
            })
            ->whereNotNull('processed_at')
            ->where('used_price', true)
            ->whereBetween('ended_at', [now()->subMonths(6), now()])
            ->orderBy('ended_at', 'DESC')
            ->paginate(12)
        ;
        $cars->appends([
            'search' => $search,
            'make' => $request->get('make', null)
        ]);

        $makes = Make::whereNull('parent_id')->defaultOrder()->get()->map(function($make) {
            $filterMakes = Make::descendantsAndSelf($make->id)->pluck('id')->toArray();
            $cars = EbayItem::query()
                ->whereHas('images')
                ->whereNotNull('processed_at')
                ->whereBetween('ended_at', [now()->subMonths(6), now()])
                ->where('used_price', true)
                ->whereIn('make_id', $filterMakes)
                ->count();
            return [
                'id' => $make->id,
                'name' => $make->name,
                'slug' => $make->slug,
                'cars' => $cars
            ];
        });

        return Inertia::render('Cars/Index', [
            'cars' => $cars,
            'makes' => $makes,
            'make' => $request->get('make', null),
            'search' => $search
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EbayItem  $ebayItem
     * @return \Illuminate\Http\Response
     */
    public function show(EbayItem $ebayItem)
    {
        //
    }

    /**
     * Change bookmark status of ebay_item
     *
     * @param EbayItem $ebayItem
     * @return RedirectResponse
     */
    public function bookmark(EbayItem $ebayItem)
    {
        $auth = \Auth::user();

        if($auth->bookmarks()->where('ebay_item_id', $ebayItem->id)->exists()) {
            $auth->bookmarks()->where('ebay_item_id', $ebayItem->id)->delete();
        } else {
            $auth->bookmarks()->create([
                'ebay_item_id' => $ebayItem->id
            ]);
        }
        return redirect()->back();
    }

    public function redeem(EbayItem $ebayItem)
    {
        $auth = \Auth::user();

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

        return redirect()->route('redemptions');
    }
}
