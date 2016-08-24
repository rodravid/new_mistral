<?php

namespace Vinci\App\Core\Console\Commands;

use Illuminate\Console\Command;
use Vinci\App\Core\Utils\Queue\QueueWorker;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for tests';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //dd(QueueWorker::listActiveQueueWorkers());

        $urlPattern = 'http://www1.vinci.com.br/assets/website/images/wine_seals/decanter%s';

        exec('ls -la public/assets/website/images/wine_seals/decanter | grep .png', $output);

        $lines = collect($output);

        $lines->transform(function($line) use ($urlPattern) {

            $segments = explode(' ', $line);

            $imgName = end($segments);

            return sprintf($urlPattern, $imgName);

        });

        foreach ($lines as $line) {

            file_put_contents(storage_path('app/seals.txt'), $line . PHP_EOL, FILE_APPEND);

        }

    }

}
