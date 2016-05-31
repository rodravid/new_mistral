<?php

namespace Vinci\App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Vinci\App\Core\Console\Commands\DoctrineTruncateTable;
use Vinci\App\Core\Console\Commands\ImportCustomers;
use Vinci\App\Core\Console\Commands\ImportProduct;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DoctrineTruncateTable::class,
        ImportProduct::class,
        ImportCustomers::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
