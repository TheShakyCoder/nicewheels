<?php

namespace App\Console\Commands;

use App\Models\Make;
use App\Services\EbayItemService;
use App\Services\StaticService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class StaticFilter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'static:filter';

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
    public function handle(StaticService $staticService, EbayItemService $ebayItemService)
    {
        $makes = Make::select('id')->defaultOrder()->withDepth()->where('live', true)->get();
        foreach($makes as $make) {
            $treeMake = Make::ancestorsAndSelf($make->id);
            $fullMake = $staticService->getFullMake($treeMake);
            $folder = $staticService->getFolder($treeMake);
            $makeAndDescendants = Make::descendantsAndSelf($make->id);

            $cars = $ebayItemService->getPublicEbayItems(0, 12, null, $makeAndDescendants);
            $lastPage = json_decode($cars->toJson())->last_page;

            //  GET THE COMPILED HTML
            $html = $staticService->getCompiledHtml('templates.filter', $fullMake, $cars, $lastPage, $makeAndDescendants->pluck('id'), $makes, $folder);

            try {
                mkdir(public_path('used-prices/'.$folder), 0775, true);
            } catch(\Exception $e) {
                //
            }

            if(file_exists(public_path('used-prices/'.$folder.'/index.html'))) {
                unlink(public_path('used-prices/'.$folder.'/index.html'));
            }
            file_put_contents(public_path('used-prices/'.$folder.'/index.html'), $html);

            echo $fullMake.PHP_EOL;
            echo $folder.PHP_EOL;
            echo PHP_EOL;
        }

        //  used price index
        $cars = $ebayItemService->getPublicEbayItems(0, 12, null);
        $lastPage = json_decode($cars->toJson())->last_page;
        $folder = '';
        $html = $staticService->getCompiledHtml('templates.filter', 'All Makes', $cars, $lastPage, [], $makes, $folder);
        file_put_contents(public_path('used-prices/index.html'), $html);
        echo 'used-prices/index.html'.PHP_EOL;

        return 0;
    }
}
