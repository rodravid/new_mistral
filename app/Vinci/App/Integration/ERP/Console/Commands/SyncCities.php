<?php
namespace Vinci\App\Integration\ERP\Console\Commands;

use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\City\CityService;
use Vinci\Domain\Address\State\StateRepository;

class SyncCities extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:sync-cities 
                            {states?* : IDs array of cities}
                            {--all : Import all cities of all states}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync cities from ERP';

    private $cityService;

    private $stateRepository;

    /**
     * Create a new command instance.
     *
     * @param CityService $cityService
     * @param StateRepository $stateRepository
     */
    public function __construct(CityService $cityService, StateRepository $stateRepository)
    {
        parent::__construct();

        $this->cityService = $cityService;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stateIDs = ($this->option('all')) ? $this->stateRepository->getAllStateIDs() : $this->argument('states');

        foreach ($stateIDs as $stateID) {
            $this->syncCitiesFromState($stateID);
        }
    }

    public function syncCitiesFromState($stateID)
    {
        $cities = $this->cityService->getCitiesFromState($stateID);
        $this->info(sprintf("\nImporting %s cities from state %s", count($cities), $stateID));

        $progressBar = $this->output->createProgressBar(count($cities));

        foreach ($cities as $city) {
            $city['state_id'] = $stateID;
            $this->cityService->syncCity($city);

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info(sprintf("\nAll %s cities of state %s imported", count($cities), $stateID));
    }

}