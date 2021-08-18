<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EbayItem;

class AdminController extends Controller
{
    public function __invoke()
    {
        $notAspectedCount = EbayItem::query()
            ->whereNull('aspected_at')
            ->count();

        $notProcessedCount = EbayItem::query()
            ->whereNull('processed_at')
            ->count();

            

        $carsNotAssignedToModels = \DB::select('select m.name, count(ei.id) AS quantity from ebay_items ei join makes m on m.id = ei.make_id where m.parent_id is null and ei.deleted_at is null group by ei.make_id order by count(ei.id) DESC');


        return Inertia::render('Admin/Index', [
            'notAspectedCount' => $notAspectedCount,
            'notProcessedCount' => $notProcessedCount,
            'carsNotAssignedToModels' => $carsNotAssignedToModels
        ]);
    }
}
