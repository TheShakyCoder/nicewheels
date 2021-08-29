<?php

namespace App\Console\Commands;

use App\Models\EbayAspect;
use App\Models\EbayItem;
use App\Services\EbayItemService;
use App\Services\EbayService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EbayGet extends Command
{
    private $ebayService;
    private $ebayItemService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:get';

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
    public function __construct(EbayService $ebayService, EbayItemService $ebayItemService)
    {
        parent::__construct();
        $this->ebayService = $ebayService;
        $this->ebayItemService = $ebayItemService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = EbayItem::query()->whereNull('aspected_at')->where('used_price', true)->orderBy('ended_at', 'ASC')->limit(config('ebay.settings.itemsPerGet'))->pluck('ebay_item_id')->toArray();
        if(count($items) > 0) {
            $json = $this->ebayService->getMultipleItems($items, true);
            $this->ebayItemService->checkForErrors($json);
            $this->ebayItemService->patchItemsFromJson($json);
        }
        echo "Items: ".count($items).PHP_EOL;
        return 0;
    }
}
