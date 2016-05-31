<?php

namespace Vinci\App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Vinci\App\Core\Console\Commands\DoctrineTruncateTable;
use Vinci\App\Core\Console\Commands\ImportCustomers;
use Vinci\App\Core\Console\Commands\ImportProduct;
use Vinci\App\Core\Console\Commands\MakeSlugCountry;
use Vinci\App\Core\Console\Commands\MakeSlugGrape;
use Vinci\App\Core\Console\Commands\MakeSlugGrapes;
use Vinci\App\Core\Console\Commands\MakeSlugProducer;
use Vinci\App\Core\Console\Commands\MakeSlugProductType;
use Vinci\App\Core\Console\Commands\MakeSlugRegion;
use Vinci\App\Website\Search\Console\Commands\IndexProducts;

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
        IndexProducts::class,
        ImportCustomers::class,
        MakeSlugCountry::class,
        MakeSlugRegion::class,
        MakeSlugProducer::class,
        MakeSlugProductType::class,
        MakeSlugGrapes::class
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
