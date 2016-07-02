<?php

namespace Vinci\App\Integration\ERP\Product;

use Vinci\Domain\ERP\Product\ProductService;
use Vinci\Domain\Product\Services\ProductManagementService;

class ProductImporter
{

    protected $erpProductService;

    protected $localProductService;

    public function __construct(ProductService $erpProductService, ProductManagementService $localProductService)
    {
        $this->erpProductService = $erpProductService;
        $this->localProductService = $localProductService;
    }

    public function importAllProducts()
    {

        $products = $this->erpProductService->getOneBySKU(123);

        dd($products);



        $this->localProductService->create([]);


    }



}