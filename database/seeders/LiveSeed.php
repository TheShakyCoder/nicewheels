<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EbayCategory;
use App\Models\Make;
use Illuminate\Database\Seeder;

class LiveSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makes = collect(config('seed.live.makes'));
        $makes->each(function($make) {
            $models = isset($make['models']) ? collect($make['models']) : collect([]);
            $aspects = isset($make['aspects']) ? collect($make['aspects']) : collect([]);
            unset($make['models']);
            unset($make['aspects']);
            $entry = Make::query()->create($make);
            $aspects->each(function($aspect) use($entry) {
                $entry->alternatives()->create([
                    'name' => $aspect
                ]);
            });
            $models->each(function($model) use($entry) {
                $aspects = isset($model['aspects']) ? collect($model['aspects']) : collect([]);
                unset($model['aspects']);
                $modelObject = $entry->children()->create($model);
                $aspects->each(function($aspect) use($modelObject) {
                    $modelObject->alternatives()->create([
                        'name' => $aspect
                    ]);
                });
            });
        });

        $ebayCategories = collect(config('seed.live.ebayCategories'));
        $ebayCategories->each(function($ebayCategory) {
            $make = Make::query()->where('slug', $ebayCategory['make'])->first();
            EbayCategory::query()->create([
                'id' => $ebayCategory['id'],
                'name' => $ebayCategory['name'],
                'poll' => $ebayCategory['poll'],
                'make_id' => $make ? $make->id : null
            ]);
        });

        $colCategories = collect(config('seed.live.categories'));
        $colCategories->each(function($colCategory) {
            $colFilters = isset($colCategory['filters']) ? collect($colCategory['filters']) : collect([]);
            unset($colCategory['filters']);
            $category = Category::query()->create($colCategory);
            $colFilters->each(function($colFilter) use($category) {
                $colAspects = isset($colFilter['aspects']) ? collect($colFilter['aspects']) : collect([]);
                unset($colFilter['aspects']);
                $filter = $category->filters()->create($colFilter);
                $colAspects->each(function($colAspect) use($filter) {
                    $filter->alternatives()->create([
                        'name' => $colAspect
                    ]);
                });
            });
        });
    }
}
