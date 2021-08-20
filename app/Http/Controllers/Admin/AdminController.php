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

# FIAT
update ebay_items set make_id = 367 where make_id = 24 and (title like '%500c %');
update ebay_items set make_id = 290 where make_id = 24 and (title like '%500l %');
update ebay_items set make_id = 545 where make_id = 24 and (title like '%500x %');
update ebay_items set make_id = 94 where make_id = 24 and (title like '%500%');
update ebay_items set make_id = 288 where make_id IN(24, 126) and (title like '%grande punto%' or title like '%grand punto%');
update ebay_items set make_id = 126 where make_id IN(24) and (title like '%punto%');
update ebay_items set make_id = 272 where make_id IN(24) and (title like '%stilo%');

# MASERATI
update ebay_items set make_id = 532 where make_id = 34 and (title like '%4200%');
update ebay_items set make_id = 361 where make_id = 34 and (title like '%Quattroporte%');

# PEUGEOT
update ebay_items set make_id = 429 where make_id = 43 and (title like '%106%');
update ebay_items set make_id = 250 where make_id = 43 and (title like '%107%');
update ebay_items set make_id = 206 where make_id = 43 and (title like '%206%');
update ebay_items set make_id = 90 where make_id = 43 and (title like '%207cc%' or title like '%207 cc%');
update ebay_items set make_id = 89 where make_id = 43 and (title like '%207%');
update ebay_items set make_id = 64 where make_id = 43 and (title like '%208%');
update ebay_items set make_id = 209 where make_id = 43 and (title like '%307%');
update ebay_items set make_id = 225 where make_id = 43 and (title like '%308%');
update ebay_items set make_id = 289 where make_id = 43 and (title like '%3008%');
update ebay_items set make_id = 108 where make_id = 43 and (title like '%rcz%');

# RENAULT
update ebay_items set make_id = 78 where make_id = 45 and (title like '%clio%');
update ebay_items set make_id = 349 where make_id = 45 and (title like '%kangoo%');
update ebay_items set make_id = 319 where make_id = 45 and (title like '%laguna%');
update ebay_items set make_id = 109 where make_id = 45 and (title like '%megane%');
update ebay_items set make_id = 219 where make_id = 45 and (title like '%twingo%');

# VOLVO
update ebay_items set make_id = 433 where make_id = 57 and (title like '%850%');
update ebay_items set make_id = 213 where make_id = 57 and (title like '%s40%');
update ebay_items set make_id = 192 where make_id = 57 and (title like '%s60%');
update ebay_items set make_id = 143 where make_id = 57 and (title like '%v50%');
update ebay_items set make_id = 134 where make_id = 57 and (title like '%v70%');
update ebay_items set make_id = 214 where make_id = 57 and (title like '%xc60%');
update ebay_items set make_id = 323 where make_id = 57 and (title like '%xc70%');
update ebay_items set make_id = 95 where make_id = 57 and (title like '%xc90%');
        ");

        return redirect()->back();
    }
}
