<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\EbayItemImage;

class TempS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:s3';

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
        EbayItemImage::query()
            ->doesntHave('ebayItem')
            ->limit(10000)
            ->chunk(100, function ($ebayItemImages) {

                foreach($ebayItemImages as $ebayItemImage) {
                    //  delete these
                    
                    $file = config('filesystems.disks.spaces.folder').'/ebay-items/' . $ebayItemImage->ebay_item_id . '/' . $ebayItemImage->file;
                    echo $ebayItemImage->id.' - '.$file;
                    if(Storage::disk('spaces')->exists($file)) {
                        echo '.exists.';
                        if(Storage::disk('spaces')->delete($file)) {
                            echo '.deleted.';
                        }
                    }
                    $ebayItemImage->delete();
                    echo PHP_EOL;
                    
                }
            });
            
            
        $directories = Storage::disk('spaces')->directories(config('filesystems.disks.spaces.folder').'/ebay-items');
        echo 'got directories'.PHP_EOL;
        $count = 0;
        foreach($directories as $directory) {
            $arrayDirectory = explode('/', $directory);
            $photos = Storage::disk('spaces')->files($directory);
            foreach($photos as $file) {
                echo now().' - '.$file;
                if(Storage::disk('spaces')->delete($file)) {
                    echo '.deleted.';
                }
                echo PHP_EOL;
                //  COPY FROM fig TO nicewheels
                // if(!Storage::disk('nicewheels')->exists($newFile)) {
                //     if(Storage::disk('spaces')->move($file, $newFile)) {
                //         Storage::disk('spaces')->setVisibility($newFile, 'public');
                //         echo 'moved: ' . $file.PHP_EOL;
                //     }
                // }




            }
        }
        echo $count;




        return 0;
    }
}
