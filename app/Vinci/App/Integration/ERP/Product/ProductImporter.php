<?php

namespace Vinci\App\Integration\ERP\Product;

use Exception;
use Vinci\Domain\ERP\Product\Product;
use Vinci\Domain\ERP\Product\ProductService;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductManagementService;

class ProductImporter
{

    protected $erpProductService;

    protected $localProductService;

    protected $localProductRepository;

    public function __construct(
        ProductService $erpProductService,
        ProductManagementService $localProductService,
        ProductRepository $localProductRepository
    ) {
        $this->erpProductService = $erpProductService;
        $this->localProductService = $localProductService;
        $this->localProductRepository = $localProductRepository;
    }

    public function importOneBySKU($sku)
    {
        try {

            $localProduct = $this->localProductRepository->findOneBySKU($sku);
            $erpProduct = $this->erpProductService->getOneBySKU($sku);

            if (! $localProduct) {
                return $this->createProduct($erpProduct);
            }

            return $this->updateProduct($erpProduct, $localProduct);

        } catch (Exception $e) {

            $this->log($e->getMessage());

            throw $e;
        }

    }

    protected function createProduct(Product $product)
    {
        return $this->localProductService->create($product->toArray());
    }

    protected function updateProduct(Product $product, ProductInterface $localProduct)
    {
        $data = $product->toArray();

        return $this->localProductService->update($data, $localProduct->getId());
    }

    public function log($message)
    {

    }

}