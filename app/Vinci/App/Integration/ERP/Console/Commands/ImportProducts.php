<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\Product\ProductImporter;

class ImportProducts extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:products:import {product? : The SKU of the product}';

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

        $productSku = $this->getProductSku();

        if ($productSku) {
            $this->productImporter->importOneBySKU($productSku);
        }


    }

    public function getProductSku()
    {
        return $this->argument('product');
    }

}