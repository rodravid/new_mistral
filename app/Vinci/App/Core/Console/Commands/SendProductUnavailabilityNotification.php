<?php

namespace Vinci\App\Core\Console\Commands;

use Illuminate\Console\Command;

class SendProductUnavailabilityNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:send-unavailability-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notification with products out of stock.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        


    }

}
