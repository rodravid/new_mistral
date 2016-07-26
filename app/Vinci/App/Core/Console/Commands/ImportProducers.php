<?php

namespace Vinci\App\Core\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Producer\ProducerService;

class ImportProducers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:producers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import producers';

    private $producerService;

    public function __construct(ProducerService $producerService)
    {
        parent::__construct();

        $this->producerService = $producerService;
    }

    public function handle()
    {
        $db = DB::connection('homolog');

        $producers = collect($db->table('w11_producers as p')->join('w11_producers_regions_relationship as pr', 'p.id', '=', 'pr.producer_id')->get());

        if ($total = $producers->count()) {

            $this->info(sprintf('Importing %s producers...', $total));
            $bar = $this->output->createProgressBar($total);
            $success = 0;
            $errors = 0;

            foreach ($producers as $producer) {

                try {

                    $this->producerService->create([
                        'id' => $producer->id,
                        'region_id' => $producer->region_id,
                        'name' => $producer->title,
                        'description' => $producer->description,
                        'slug' => $producer->slug,
                        'visible_site' => $producer->visibleSite,
                        'status' => 1,
                        'seoTitle' => $producer->seo_title,
                        'seoDescription' => $producer->seo_description,
                    ]);

                    $success++;

                } catch (Exception $e) {

                    throw $e;

                    $errors++;
                }

                $bar->advance();

            }

            $bar->finish();

            $this->info('Done!');

            if ($success > 0) {
                $this->info(sprintf('%s producers imported with success!', $success));
            }

            if ($errors > 0) {
                $this->error(sprintf('%s producers were not imported!', $errors));
            }

        } else {
            $this->info('Nothing to do.');
        }

    }

}