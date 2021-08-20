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

# HYUNDAI
update ebay_items set make_id = 123 where make_id = 27 and (title like '%i10%');
update ebay_items set make_id = 227 where make_id = 27 and (title like '%i30%');

# KIA
update ebay_items set make_id = 125 where make_id = 30 and (title like '%picanto%');
update ebay_items set make_id = 153 where make_id = 30 and (title like '%rio%');

# MASERATI
update ebay_items set make_id = 532 where make_id = 34 and (title like '%4200%');
update ebay_items set make_id = 361 where make_id = 34 and (title like '%Quattroporte%');

# MITSUBISHI
update ebay_items set make_id = 124 where make_id = 39 and (title like '%colt%');
update ebay_items set make_id = 124 where make_id = 39 and (title like '%colt%');
update ebay_items set make_id = 271 where make_id in(39, 239) and (title like '%evolution%' or title like '%evo%');
update ebay_items set make_id = 239 where make_id = 39 and (title like '%lancer%');
update ebay_items set make_id = 307 where make_id = 39 and (title like '%outlander%');

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

# PORSCHE
update ebay_items set make_id = 84 where make_id = 44 and (title like '%boxster%' or title like '%boxter%');
update ebay_items set make_id = 164 where make_id = 44 and (title like '%cayenne%');

# RENAULT
update ebay_items set make_id = 78 where make_id = 45 and (title like '%clio%');
update ebay_items set make_id = 349 where make_id = 45 and (title like '%kangoo%');
update ebay_items set make_id = 319 where make_id = 45 and (title like '%laguna%');
update ebay_items set make_id = 109 where make_id = 45 and (title like '%megane%');
update ebay_items set make_id = 219 where make_id = 45 and (title like '%twingo%');

# SAAB
update ebay_items set make_id = 176 where make_id = 47 and (title like '%9-3%');

# SEAT
update ebay_items set make_id = 96 where make_id = 48 and (title like '%altea%');
update ebay_items set make_id = 61 where make_id = 48 and (title like '%ibiza%');
update ebay_items set make_id = 152 where make_id = 48 and (title like '%leon%');



# SUBARU
update ebay_items set make_id = 73 where make_id = 51 and (title like '%impreza%');

# SUZUKI
update ebay_items set make_id = 98 where make_id = 52 and (title like '%alto%');
update ebay_items set make_id = 310 where make_id = 52 and (title like '%ignis%');
update ebay_items set make_id = 119 where make_id = 52 and (title like '%jimny%');
update ebay_items set make_id = 171 where make_id = 52 and (title like '%swift%');
update ebay_items set make_id = 222 where make_id = 52 and (title like '%grand vitara%');

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
