<?php

namespace App\Console\Commands;

use App\Models\EbayAspect;
use App\Models\EbayItem;
use App\Services\EbayItemService;
use App\Services\EbayService;
use Illuminate\Console\Command;

class EbayFinish extends Command
{
    private $ebayService;
    private $ebayItemService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:finish';

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
        $items = EbayItem::query()
            ->where('ended_at', '<', now())
            ->where('ended_at', '>', now()->subMonths(config('ebay.settings.usedMonths')))
            ->whereNotNull('aspected_at')
            ->whereNull('processed_at')
            ->where('used_price', true)
            ->orderBy('ended_at', 'ASC')
            ->limit(config('ebay.settings.itemsPerFinish'))
            ->pluck('ebay_item_id')
            ->toArray();

        if(!$json = $this->ebayService->getMultipleItems($items)) {
            echo "Items: 0".PHP_EOL;
            return 0;
        }

        $this->ebayItemService->checkForErrors($json);

        foreach($json->Item as $item) {
            $patch = [
                'bids' => $item->BidCount,
                'final_amount' => $item->ConvertedCurrentPrice->Value,
                'processed_at' => now()
            ];
            EbayItem::where('ebay_item_id', $item->ItemID)->update($patch);
        }

        echo "Items: ".count($items).PHP_EOL;
        return 0;
    }
}
