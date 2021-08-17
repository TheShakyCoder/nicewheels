<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EbayItem;
use App\Models\Make;

class StaticCompile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $makes = Make::select('id')->where('live', true)->get();
        foreach($makes as $make) {
            $descendants = Make::descendantsAndSelf($make->id)->pluck('id');
            $cars = EbayItem::whereIn('make_id', $descendants)->pluck('id');
            $make->cars_count = count($cars);
            $make->cars_csv = count($cars) ? implode(',', $cars->toArray()) : null;
            $make->save();
        }
        return 0;
    }
}
