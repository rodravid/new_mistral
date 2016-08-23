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
        dd(QueueWorker::listActiveQueueWorkers());
    }

}
