<?php

namespace App\Console\Commands;

use App\Models\EbayCategory;
use App\Services\EbayItemService;
use App\Services\EbayService;
use Illuminate\Console\Command;

class EbayPoll extends Command
{
    private $ebayService;
    private $ebayItemService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebay:poll';

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
        $ebayCategory = EbayCategory::where('poll', true)->orderBy('polled_at', 'ASC')->first();
        $json = $this->ebayService->findItemsByCategory($ebayCategory);
        $count = $this->ebayItemService->createItemsFromJson($ebayCategory, $json);
        $ebayCategory->fill([
            'polled_at' => \Carbon\Carbon::now()->format('Y-m-d G:i:s'),
            'qty_received' => $count
        ]);
        $ebayCategory->save();

        return 0;
    }
}
