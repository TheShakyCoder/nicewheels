<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EbayItem;
use App\Models\Make;
use App\Models\Substitution;

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

        $carsNotAssignedToModels = \DB::select('select m.id, m.name, count(ei.id) AS quantity from ebay_items ei join makes m on m.id = ei.make_id where ei.deleted_at is null group by ei.make_id order by count(ei.id) DESC');

        return Inertia::render('Admin/Index', [
            'notAspectedCount' => $notAspectedCount,
            'notProcessedCount' => $notProcessedCount,
            'carsNotAssignedToModels' => $carsNotAssignedToModels
        ]);
    }

    public function sql()
    {
        $substitutions = Substitution::query()->orderBy('make_id', 'ASC')->orderBy('sort', 'ASC')->get();

        foreach($substitutions as $substitution) {
            EbayItem::query()
                ->when($substitution->make_id, function($q) use($substitution) {
                    $q->where('make_id', $substitution->make_id);
                }, function($q) use($substitution) {
                    $descendantsAndSelf = Make::descendantsAndSelf($substitution->to_make_id)->pluck('id')->toArray();
                    $q->whereNotIn('make_id', $descendantsAndSelf);
                })
                ->where('title', 'LIKE', $substitution->search)
                ->update(['make_id' => $substitution->to_make_id]);
        }

        return redirect()->back();
    }
}
