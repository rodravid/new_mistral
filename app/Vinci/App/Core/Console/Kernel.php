<?php

namespace Vinci\App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Vinci\App\Core\Console\Commands\ClearCreditCards;
use Vinci\App\Core\Console\Commands\DoctrineTruncateTable;
use Vinci\App\Core\Console\Commands\GenerateOrders;
use Vinci\App\Core\Console\Commands\ImportCountries;
use Vinci\App\Core\Console\Commands\ImportCustomers;
use Vinci\App\Core\Console\Commands\ImportOldOrders;
use Vinci\App\Core\Console\Commands\ImportProducers;
use Vinci\App\Core\Console\Commands\ImportProduct;
use Vinci\App\Core\Console\Commands\ImportProductsPhotos;
use Vinci\App\Core\Console\Commands\ImportProductsTypes;
use Vinci\App\Core\Console\Commands\ImportRegions;
use Vinci\App\Core\Console\Commands\MakeSlugCountry;
use Vinci\App\Core\Console\Commands\MakeSlugGrapes;
use Vinci\App\Core\Console\Commands\MakeSlugProducer;
use Vinci\App\Core\Console\Commands\MakeSlugProductType;
use Vinci\App\Core\Console\Commands\MakeSlugRegion;
use Vinci\App\Core\Console\Commands\RandomizeProductTemplate;
use Vinci\App\Core\Console\Commands\SendProductUnavailabilityNotification;
use Vinci\App\Core\Console\Commands\Test;
use Vinci\App\Core\Console\Commands\UniqueIdTest;
use Vinci\App\Website\Search\Console\Commands\SyncProducts;

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
        SyncProducts::class,
        ImportCustomers::class,
        MakeSlugCountry::class,
        MakeSlugRegion::class,
        MakeSlugProducer::class,
        MakeSlugProductType::class,
        MakeSlugGrapes::class,
        RandomizeProductTemplate::class,
        UniqueIdTest::class,
        ImportCountries::class,
        ImportRegions::class,
        ImportProducers::class,
        ImportProductsTypes::class,
        ImportProductsPhotos::class,
        ImportOldOrders::class,
        ClearCreditCards::class,
        Test::class,
        SendProductUnavailabilityNotification::class,
        GenerateOrders::class,
        'Vinci\App\Integration\ERP\Console\Commands\ImportProducts',
        'Vinci\App\Integration\ERP\Console\Commands\ImportProductsStock',
        'Vinci\App\Integration\ERP\Console\Commands\ImportProductsPrice',
        'Vinci\App\Integration\ERP\Console\Commands\ExportCustomers',
        'Vinci\App\Integration\ERP\Console\Commands\ExportOrders',
        'Vinci\App\Integration\ERP\Console\Commands\ExportOrdersItems'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('erp:integration:products:import --new')
            ->cron('*/30 * * * *');

        $schedule->command('erp:integration:products:import --changed')
            ->cron('*/15 * * * *');

        $schedule->command('erp:integration:products:import --all')
            ->cron('00 */1 * * *');

        $schedule->command('erp:integration:products:import-price --all')
            ->cron('10 */1 * * *');

        $schedule->command('erp:integration:products:import-stock --all')
            ->cron('*/25 * * * *');

        $schedule->command('search:sync')
            ->everyTenMinutes();

        $schedule->command('product:send-unavailability-notification')
            ->cron('0 6-23/2 * * *');

        $schedule->command('creditcards:clear')
            ->daily();
    }
}
