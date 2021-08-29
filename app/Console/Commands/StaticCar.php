<?php

namespace App\Console\Commands;

use App\Models\EbayItem;
use App\Models\Make;
use App\Services\StaticService;
use Illuminate\Console\Command;

class StaticCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static:car';

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
    public function handle(StaticService $staticService)
    {
        $makes = Make::select('id')->defaultOrder()->withDepth()->where('live', true)->get();

        $cars = EbayItem::query()
            ->where('used_price', 1)
            ->get();

        $cars->each(function ($car) use($makes, $staticService) {

            echo $car->slug.PHP_EOL;

            $html = $staticService->getCarCompiledHtml('templates.car', $car, $makes);

            try {
                mkdir(public_path('used-prices/cars/'.$car->slug), 0775, true);
            } catch(\Exception $e) {
                //
            }

            if(file_exists(public_path('used-prices/cars/'.$car->slug.'/index.html'))) {
                unlink(public_path('used-prices/cars/'.$car->slug.'/index.html'));
            }
            file_put_contents(public_path('used-prices/cars/'.$car->slug.'/index.html'), $html);

        });

        return 0;
    }
}
