<?php

namespace Vinci\App\Integration\ERP\Product;

use Vinci\Domain\ERP\Product\Product;
use Vinci\Domain\ERP\Product\ProductService;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductManagementService;

class ProductImporter
{

    protected $erpProductService;

    protected $localProductService;

    protected $localProductRepository;

    public function __construct(ProductService $erpProductService, ProductManagementService $localProductService, ProductRepository $localProductRepository)
    {
        $this->erpProductService = $erpProductService;
        $this->localProductService = $localProductService;
        $this->localProductRepository = $localProductRepository;
    }

    public function importOneBySKU($sku)
    {
        $localProduct = $this->localProductRepository->findOneBySKU($sku);
        $erpProduct = $this->erpProductService->getOneBySKU($sku);

        dd($erpProduct);

        if (! $localProduct) {
            return $this->createProduct($erpProduct);
        }

        return $this->updateProduct($erpProduct, $localProduct->getId());
    }

    protected function createProduct(Product $product)
    {
        return $this->localProductService->create($product->toArray());
    }

    protected function updateProduct(Product $product, $id)
    {
        return $this->localProductService->update($product->toArray(), $id);
    }

    public function importAllProducts()
    {

        $product = $this->erpProductService->getOneBySKU(28776);




        dd($product);

        //$this->localProductService->create([]);


    }



}