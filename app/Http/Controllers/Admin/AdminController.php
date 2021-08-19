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

# FORD
update ebay_items set make_id = 131 where make_id = 25 and (title like '%fiesta%');
update ebay_items set make_id = 110 where make_id = 25 and (title like '%focus%');
update ebay_items set make_id = 132 where make_id = 25 and (title like '% ka%');
update ebay_items set make_id = 400 where make_id = 25 and (title like '%kuga%' or title like '%kugga%');
update ebay_items set make_id = 142 where make_id = 25 and (title like '%mondeo%');



# HYUNDAI
update ebay_items set make_id = 123 where make_id = 27 and (title like '%i10%');
update ebay_items set make_id = 227 where make_id = 27 and (title like '%i30%');

# JAGUAR
update ebay_items set make_id = 111 where make_id = 28 and (title like '%f type%' or title like '%f-type%');
update ebay_items set make_id = 117 where make_id = 28 and (title like '%s type%' or title like '%s-type%' or subtitle like '%s type%' or subtitle like '%s-type%');
update ebay_items set make_id = 128 where make_id = 28 and (title like '%x type%' or title like '%x-type%');
update ebay_items set make_id = 329 where make_id = 28 and (title like '%xe %');
update ebay_items set make_id = 80 where make_id = 28 and (title like '%xf %');
update ebay_items set make_id = 259 where make_id = 28 and (title like '%xj6%');
update ebay_items set make_id = 326 where make_id = 28 and (title like '%xj8%');
update ebay_items set make_id = 210 where make_id = 28 and (title like '%xk8%');

# KIA
update ebay_items set make_id = 125 where make_id = 30 and (title like '%picanto%');
update ebay_items set make_id = 153 where make_id = 30 and (title like '%rio%');


# MASERATI
update ebay_items set make_id = 532 where make_id = 34 and (title like '%4200%');
update ebay_items set make_id = 361 where make_id = 34 and (title like '%Quattroporte%');

# MAZDA
update ebay_items set make_id = 285 where make_id = 35 and (title like '%mazda 2 %' or title like '%mazda2 %');
update ebay_items set make_id = 555 where make_id = 35 and (title like '%bongo%');
update ebay_items set make_id = 377 where make_id = 35 and (title like '%cx-7%' or title like '%cx7%');
update ebay_items set make_id = 87 where make_id = 35 and (title like '%mx-5%' or title like '%mx5%');
update ebay_items set make_id = 157 where make_id = 35 and (title like '%mazda 3 %' or title like '%mazda 3');
update ebay_items set make_id = 230 where make_id = 35 and (title like '%mazda 6 %' or title like '%mazda 6');
update ebay_items set make_id = 92 where make_id = 35 and (title like '%rx7%' or title like '%rx-7');
update ebay_items set make_id = 258 where make_id = 35 and (title like '%rx8%' or title like '%rx-8');





# MITSUBISHI
update ebay_items set make_id = 124 where make_id = 39 and (title like '%colt%');
update ebay_items set make_id = 124 where make_id = 39 and (title like '%colt%');
update ebay_items set make_id = 271 where make_id in(39, 239) and (title like '%evolution%' or title like '%evo%');
update ebay_items set make_id = 239 where make_id = 39 and (title like '%lancer%');
update ebay_items set make_id = 307 where make_id = 39 and (title like '%outlander%');

# NISSAN
update ebay_items set make_id = 439 where make_id = 41 and (title like '%350z%');
update ebay_items set make_id = 356 where make_id = 41 and (title like '%almera%');
update ebay_items set make_id = 405 where make_id = 41 and (title like '%cube%');
update ebay_items set make_id = 331 where make_id = 41 and (title like '%elgrand%');
update ebay_items set make_id = 127 where make_id = 41 and (title like '%juke%');
update ebay_items set make_id = 65 where make_id = 41 and (title like '%leaf%');
update ebay_items set make_id = 203 where make_id = 41 and (title like '%micra%');
update ebay_items set make_id = 311 where make_id = 41 and (title like '%note%');
update ebay_items set make_id = 412 where make_id = 41 and (title like '%pathfinder%');
update ebay_items set make_id = 452 where make_id = 41 and (title like '%patrol%');
update ebay_items set make_id = 294 where make_id = 41 and (title like '%primera%');
update ebay_items set make_id = 129 where make_id = 41 and (title like '%qashqai%');
update ebay_items set make_id = 425 where make_id = 41 and (title like '%serena%');
update ebay_items set make_id = 232 where make_id = 41 and (title like '%x trail%' or title like '%xtrail%');

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

# SKODA
update ebay_items set make_id = 243 where make_id = 49 and (title like '%fabia%');
update ebay_items set make_id = 139 where make_id = 49 and (title like '%octavia%');

# SUBARU
update ebay_items set make_id = 73 where make_id = 51 and (title like '%impreza%');

# SUZUKI
update ebay_items set make_id = 98 where make_id = 52 and (title like '%alto%');
update ebay_items set make_id = 310 where make_id = 52 and (title like '%ignis%');
update ebay_items set make_id = 119 where make_id = 52 and (title like '%jimny%');
update ebay_items set make_id = 171 where make_id = 52 and (title like '%swift%');
update ebay_items set make_id = 222 where make_id = 52 and (title like '%grand vitara%');




# VOLKSWAGEN
update ebay_items set make_id = 104 where make_id = 56 and (title like '%beetle%');
update ebay_items set make_id = 81 where make_id = 56 and (title like '%golf%');
update ebay_items set make_id = 163 where make_id = 56 and (title like '%passat%');
update ebay_items set make_id = 262 where make_id = 56 and (title like '%polo%');
update ebay_items set make_id = 300 where make_id = 56 and (title like '%sharan%');
update ebay_items set make_id = 369 where make_id = 56 and (title like '%touareg%');

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
