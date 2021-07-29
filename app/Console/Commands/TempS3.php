<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
        $exempt = explode(',', config('filesystems.disks.ams3.exempts'));

        $directories = Storage::disk('ams3')->directories('/fig/ebay-items');
        foreach($directories as $directory) {
            $arrayDirectory = explode('/', $directory);
            if (in_array($arrayDirectory[2], $exempt)) {
                continue;
            }
            $photos = Storage::disk('ams3')->files($directory);
            foreach($photos as $file) {
                echo now().' - ';
                if(Storage::disk('spaces')->exists($file)) {
                    echo $file.' exists'.PHP_EOL;
                    if(!Storage::disk('ams3')->delete($file)) {
                        echo 'could not delete '.$file.' on AMS3'.PHP_EOL;
                    }
                    continue;
                }
                try {
                    echo $file.PHP_EOL;
                    $fs = Storage::disk('ams3')->getDriver();
                    $stream = $fs->readStream($file);
                    $new_fs = Storage::disk('spaces')->getDriver();
                    $new_fs->writeStream($file, $stream);
                    if(!Storage::disk('ams3')->delete($file)) {
                        echo 'could not delete '.$file.' on AMS3'.PHP_EOL;
                    }
                } catch(\Exception $e) {
                    echo $e->getMessage().PHP_EOL;
                }
            }
        }
        echo $count;
        return 0;
    }
}
