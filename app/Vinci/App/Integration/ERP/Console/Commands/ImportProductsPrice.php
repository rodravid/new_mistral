<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Vinci\App\Integration\ERP\Product\ProductImporter;
use Vinci\Domain\ERP\Product\ProductService;

class ImportProductsPrice extends ImportProducts
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import-price 
                            {products?* : IDs array of products}
                            {--all : Import all products from ERP}
                            {--new : Import only new products from ERP}
                            {--changed : Import only changed products from ERP}
                            {--exceptions : Throws exceptions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products price from ERP.';

    public function __construct(ProductImporter $productImporter, ProductService $productService)
    {
        parent::__construct($productImporter, $productService);
    }

    public function handle()
    {
        $productsSKU = $this->getProductsSKU();

        if($productsSKU->count()) {

           if ($productsSKU->count() == 1) {
               $this->importPriceOfOne($productsSKU->first(), false, $this->option('exceptions'));

           } else {
               $this->importPriceOfMany($productsSKU);
           }

        } else {
            $this->info('Nothing to do.');
        }
    }

    public function importPriceOfOne($productSKU, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Importing price of product #%s from ERP...', $productSKU));
        }

        try {

            $this->productImporter->importPrice($productSKU);

            if (! $silent) {
                $this->info(sprintf('Done!'));
            }

        } catch (Exception $e) {

            if ($exceptions) {
                throw $e;
            }

            if (! $silent) {
                $this->error($e->getMessage());
            }

        }
    }

    public function importPriceOfMany($productsSKU)
    {
        $progressBar = $this->output->createProgressBar($productsSKU->count());

        $this->info(sprintf('Importing stock of %s products from ERP...', $productsSKU->count()));
        $success = [];
        $error = [];

        foreach ($productsSKU as $productSKU) {

            try {

                $this->importPriceOfOne($productSKU, true);

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

}