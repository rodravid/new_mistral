<?php

namespace Vinci\App\Website\Search\Console\Commands;

use Illuminate\Console\Command;
use Vinci\Domain\Search\Product\ProductIndexerService;

class SyncProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:sync { --index }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index products in elasticsearch';


    private $indexerService;

    public function __construct(ProductIndexerService $indexerService)
    {
        parent::__construct();

        $this->indexerService = $indexerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('index')) {
            $this->runIndexCreation();
        }

        $this->message("Indexing products in elasticsearch...");

        $response = $this->indexerService->syncAll();

        $total = count($response['items']);

        $this->info(sprintf("\nDone!\n%s products were indexed in elasticsearch.\n", $total));
    }

    public function message($message, $color = 'blue')
    {
        $this->getOutput()->writeln('<fg=' . $color . '>' . $message . '</fg=' . $color . '>');
    }

    private function runIndexCreation()
    {
        $index = $this->indexerService->getIndex();

        $this->message(sprintf('Creating index <info>%s</info> in elasticsearch...', $index->getName()));

        $this->indexerService->createIndex();

        $this->info("Done!\n");
    }

}