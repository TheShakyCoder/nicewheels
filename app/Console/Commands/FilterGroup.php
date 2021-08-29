<?php

namespace App\Console\Commands;

use App\Models\EbayAspect;
use App\Models\EbayItem;
use App\Models\Filter;
use Illuminate\Console\Command;

class FilterGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Filters into aggregate data';

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
        Filter::query()->with('alternatives', 'category')->get()->each(function($filter) {
            $ebayItems = $filter->ebayItems->pluck('id')->toArray();
            $filter->csv = implode(',', $ebayItems);
            $filter->quantity = count($ebayItems);
            $filter->save();
        });
        return 0;
    }
}
