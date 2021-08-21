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
            ->where('used_price', 1)
            ->whereNull('deleted_at')
            ->count();

        $notProcessedCount = EbayItem::query()
            ->whereNull('processed_at')
            ->where('used_price', 1)
            ->whereNull('deleted_at')
            ->count();

            

        $carsNotAssignedToModels = \DB::select('select m.id, m.name, count(ei.id) AS quantity from ebay_items ei join makes m on m.id = ei.make_id where m.parent_id is null and ei.deleted_at is null group by ei.make_id order by count(ei.id) DESC');


        return Inertia::render('Admin/Index', [
            'notAspectedCount' => $notAspectedCount,
            'notProcessedCount' => $notProcessedCount,
            'carsNotAssignedToModels' => $carsNotAssignedToModels
        ]);
    }

    public function sql()
    {
        $updates = collect(config('common.updates'));

        foreach($updates as $update) {
            foreach($update['titles'] as $title) {
                EbayItem::query()->whereIn('make_id', $update['from'])->where('title', 'LIKE', $title)->update(['make_id' => $update['to']]);
            }
        }


        \DB::raw("

update ebay_items set make_id = 312 where make_id = 19 and (title like '%aveo%');
update ebay_items set make_id = 337 where make_id = 19 and (title like '%captiva%');
update ebay_items set make_id = 516 where make_id = 19 and (title like '%cruze%');
update ebay_items set make_id = 375 where make_id = 19 and (title like '%matiz%');

# MASERATI
update ebay_items set make_id = 532 where make_id = 34 and (title like '%4200%');
update ebay_items set make_id = 361 where make_id = 34 and (title like '%Quattroporte%');





        ");

        return redirect()->back();
    }
}
