<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Make;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EbayItem;

class EbayItemsController extends Controller
{
    public function index()
    {
        $ebayItems = EbayItem::query()
            ->with(['images'])
            ->whereNotNull('aspected_at')
            ->whereNull('checked_at')
            ->where('used_price', 1)
            ->orderBy('ended_at', 'ASC')
            ->paginate(12);

        return Inertia::render('Admin/EbayItems/Index', [
            'ebayItems' => $ebayItems
        ]);
    }

    public function edit(EbayItem $ebayItem)
    {
        $ebayItem->load(['filters.category', 'images' => function($q) { $q->orderBy('sort', 'ASC'); }, 'ebayCategory', 'primaryCategory', 'aspects']);
        $makes = Make::withDepth()->defaultOrder()->get();

        return Inertia::render('Admin/EbayItems/Edit', [
            'ebayItem' => $ebayItem,
            'makes' => $makes
        ]);
    }

    public function update(Request $request, EbayItem $ebayItem)
    {
        $ebayItem->fill($request->all());
        $ebayItem->checked_by = \Auth::id();
        $ebayItem->checked_at = now();
        $ebayItem->save();

        return redirect('/admin/ebay-items?updateable='.$request->get('updateable', 0));
    }
}
