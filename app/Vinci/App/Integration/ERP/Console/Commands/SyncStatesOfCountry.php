<?php
namespace Vinci\App\Integration\ERP\Console\Commands;

use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\State\StateService;

class SyncStatesOfCountry extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:countries:sync-states {ibge_country_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all states of especific country';
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * Create a new command instance.
     *
     * @param StateService $stateService
     */
    public function __construct(StateService $stateService)
    {
        parent::__construct();

        $this->stateService = $stateService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $states = $this->stateService->getStatesToSyncFromCountry($this->argument("ibge_country_code"));

        $this->info(sprintf("Importing %s states from country", count($states)));
        $this->info("\n");

        $progressBar = $this->output->createProgressBar(count($states));

        foreach ($states as $state) {

            $this->stateService->syncState($state);

            $progressBar->advance();

        }

        $progressBar->finish();

        $this->info("\n");
        $this->info(sprintf("All %s states imported", count($states)));

    }

}