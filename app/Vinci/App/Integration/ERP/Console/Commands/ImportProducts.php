<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\Product\ProductImporter;

class ImportProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import 
                            {products?* : IDs array of products}
                            {--exceptions : Throws exceptions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from ERP.';


    protected $productImporter;

    public function __construct(ProductImporter $productImporter)
    {
        parent::__construct();

        $this->productImporter = $productImporter;
    }

    public function handle()
    {
        $productsSKU = $this->getProductsSKU();

        if($productsSKU->count()) {

           if ($productsSKU->count() == 1) {
               $this->importOne($productsSKU->first(), false, $this->option('exceptions'));

           } else {
               $this->importMany($productsSKU);
           }

        } else {
            $this->info('Nothing to do.');
        }
    }

    public function importOne($productSKU, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Importing product #%s from ERP...', $productSKU));
        }

        try {

            $this->productImporter->importOneBySKU($productSKU);

            $this->info('Done!');

        } catch (Exception $e) {

            if ($exceptions) {
                throw $e;
            }

            if (! $silent) {
                $this->error($e->getMessage());
            }

        }
    }

    public function importMany($productsSKU)
    {
        $progressBar = $this->output->createProgressBar($productsSKU->count());

        $this->info(sprintf('Importing %s products from ERP...', $productsSKU->count()));
        $success = [];
        $error = [];

        foreach ($productsSKU as $productSKU) {

            try {

                $this->importOne($productSKU, true, true);

                $success[] = $productSKU;

            } catch (Exception $e) {
                $error[] = $productSKU;
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info("\n");

        if (! empty($success)) {
            $this->info(sprintf("\n%s products imported with success!", count($success)));
        }

        if (! empty($error)) {
            $this->error(sprintf("\n%s products were not imported!", count($error)));
        }
    }

    public function getProductsSKU()
    {
        return collect($this->argument('products'));
    }

}