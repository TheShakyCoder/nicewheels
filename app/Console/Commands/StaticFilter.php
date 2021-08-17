<?php

namespace App\Console\Commands;

use App\Models\Make;
use App\Services\EbayItemService;
use App\Services\NewsService;
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
    public function handle(StaticService $staticService, EbayItemService $ebayItemService, NewsService $newsService)
    {
        $makes = Make::select('id', 'parent_id')->defaultOrder()->withDepth()->where('live', true)->where('cars_count', '>', 0)->get();
        foreach($makes as $make) {
            
            $makeAndDescendants = Make::descendantsAndSelf($make->id)->pluck('id');
            $cars = $ebayItemService->getPublicEbayItems(0, config('common.static.page'), null, $makeAndDescendants, $make);
            $lastPage = json_decode($cars->toJson())->last_page;

            if($make->parent_id != null && count($cars) == 0) {
                continue;
            }

            $folder = $make->full_folder;
            echo $folder.PHP_EOL;
            
            $news = $newsService->feed(8);

            //  GET THE COMPILED HTML
            $html = $staticService->getFilterCompiledHtml('templates.filter', $make->full_name, $cars, $lastPage, $makeAndDescendants, $makes, $folder, $news);

            try {
                mkdir(public_path('used-prices/'.$folder), 0775, true);
            } catch(\Exception $e) {
                \Log::error("mkdir error: ".$e->getMessage());
            }

            if(file_exists(public_path('used-prices/'.$folder.'/index.html'))) {
                unlink(public_path('used-prices/'.$folder.'/index.html'));
            }
            file_put_contents(public_path('used-prices/'.$folder.'/index.html'), $html);

        }

        //  used price index
        $cars = $ebayItemService->getPublicEbayItems(0, 12, null);
        $lastPage = json_decode($cars->toJson())->last_page;
        $folder = '';
        $html = $staticService->getFilterCompiledHtml('templates.filter', 'All Makes', $cars, $lastPage, [], $makes, $folder, $news);
        file_put_contents(public_path('used-prices/index.html'), $html);
        echo 'used-prices/index.html'.PHP_EOL;

        return 0;
    }
}
