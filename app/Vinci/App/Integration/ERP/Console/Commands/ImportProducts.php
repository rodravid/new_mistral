<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Vinci\App\Integration\ERP\Product\ProductImporter;
use Vinci\Domain\ERP\Product\ProductService;

class ImportProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import 
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
    protected $description = 'Import products from ERP.';

    protected $productImporter;

    protected $productService;

    public function __construct(ProductImporter $productImporter, ProductService $productService)
    {
        parent::__construct();

        $this->productImporter = $productImporter;
        $this->productService = $productService;
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
        $productsInput = collect($this->argument('products'));

        if ($productsInput->count()) {
            return $productsInput;
        }

        $products = collect();

        if ($this->option('all')) {
            $all = $this->productService->getAllProducts();
            $this->appendToCollection($products, $all);
        }

        if ($this->option('new')) {
            $new = $this->productService->getNewProducts();
            $this->appendToCollection($products, $new);
        }

        if ($this->option('changed')) {
            $changed = $this->productService->getChangedProducts();
            $this->appendToCollection($products, $changed);
        }

        return $products;
    }

    protected function appendToCollection(Collection $collection, $values)
    {
        foreach ($values as $value) {
            if (! $collection->contains($value)) {
                $collection->push($value);
            }
        }
    }

}