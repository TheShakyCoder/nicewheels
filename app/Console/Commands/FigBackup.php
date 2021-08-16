<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FigBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fig:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a remote backup of the db';

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
        $ts = time();
        $ds = DIRECTORY_SEPARATOR;

        $connection = config('database.default');
        $host = config('database.connections.'.$connection.'.host');
        $database = config('database.connections.'.$connection.'.database');

        $path = storage_path('app/db_backup') . $ds;
        $file = $database.'-'.date('Ymd_Hi', $ts) . '.sql.cpt.bz2';

        $command = sprintf(
            'mysqldump --no-tablespaces --defaults-extra-file=~/.ssh/.%s.my.cnf -h %s %s | ccrypt -k ~/.ssh/.dbbackup.key | bzip2 -c > %s',
            $database,
            $host,
            $database,
            $path . $file
        );

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        exec($command);

        if(Storage::disk('spaces')->putFileAs(config('filesystems.disks.spaces.folder').'/db', $path.$file, $file)) {
            Storage::disk('local')->delete('db_backup/'.$file);
        }
    }
}
