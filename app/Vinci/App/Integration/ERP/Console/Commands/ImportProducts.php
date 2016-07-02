<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Illuminate\Console\Command;

class ImportProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from ERP.';

    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {

        $this->info('teste');

    }

}