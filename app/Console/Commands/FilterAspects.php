<?php

namespace App\Console\Commands;

use App\Models\EbayAspect;
use App\Models\Filter;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class FilterAspects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:aspects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process any Aspects into Filters';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ebayAspects = EbayAspect::query()->with('ebayItem')->whereNull('processed_at')->get();

        $ebayAspects->each(function($ebayAspect) {
            try {
                $filter = Filter::query()->whereHas('category', function($q) use($ebayAspect) {
                    $q->where('aspect', $ebayAspect->name);
                })->whereHas('alternatives', function($q) use($ebayAspect) {
                    $q->where('name', $ebayAspect->value);
                })->with('category')->firstOrFail();

                try {
                    $filter->ebayItems()->attach($ebayAspect->ebay_item_id);
                } catch (QueryException $e) {
                    echo $e->getMessage().PHP_EOL;
                }
                $ebayAspect->processed_at = now();
                $ebayAspect->save();
            } catch (ModelNotFoundException $e) {
                echo $e->getMessage().PHP_EOL;
            }
        });
        return 0;
    }
}
