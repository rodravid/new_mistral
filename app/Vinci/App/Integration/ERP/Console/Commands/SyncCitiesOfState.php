<?php
namespace Vinci\App\Integration\ERP\Console\Commands;

use Illuminate\Console\Command;
use Vinci\App\Cms\Http\Integration\ERP\City\CityService;

class SyncCitiesOfState extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:sync-cities-of-state {ibge_state_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all states of especific country';


    private $cityService;

    /**
     * Create a new command instance.
     *
     * @param CityService $cityService
     */
    public function __construct(CityService $cityService)
    {
        parent::__construct();

        $this->cityService = $cityService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = $this->cityService->syncAllCitiesOfState($this->argument('ibge_state_code'));

        dd($result);

        $this->table(['Attached', 'Updated'], array_values($result));
    }

}