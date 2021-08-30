<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Make;
use App\Models\EbayItem;

class SubstitutionsController extends Controller
{
    public function searchCount($make, $toMake, string $search)
    {
        $count = EbayItem::query()
            ->when($make != 0, function($q) use($make) {
                $q->where('make_id', $make);
            }, function($q) use($toMake) {
                $q->when($toMake, function($q2) use($toMake) {
                    $descendantsAndSelf = Make::descendantsAndSelf($toMake)->pluck('id')->toArray();
                    $q2->whereNotIn('make_id', $descendantsAndSelf);
                });
            })
            ->where('title', 'LIKE', $search)
            ->count();
        // $count = $make->ebayItems()->where('title', 'LIKE', $search)->count();

        return response()->json([
            'search' => $search,
            'count' => $count
        ], 200);
    }
}
