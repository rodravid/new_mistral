<?php

namespace Vinci\App\Website\Search\Console\Commands;

use Illuminate\Console\Command;
use Vinci\Domain\Search\Product\ProductIndexerService;

class IndexProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:index-products';

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

        $this->info('Indexing products in elasticsearch...');

        $response = $this->indexerService->indexAllProducts();

        $total = count($response['items']);

        $this->info(sprintf("%s products were indexed in elasticsearch.\n", $total));

        $this->info('Done!');

    }

}