<?php

namespace Vinci\App\Integration\ERP\Product;

use Exception;
use Log;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Integration\Exceptions\IntegrationException;
use Vinci\Domain\ERP\Product\Product;
use Vinci\Domain\ERP\Product\ProductService;
use Vinci\Domain\Inventory\InventoryService;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductManagementService;

class ProductImporter
{

    protected $erpProductService;

    protected $localProductService;

    protected $localProductRepository;

    protected $inventoryService;

    public function __construct(
        ProductService $erpProductService,
        ProductManagementService $localProductService,
        ProductRepository $localProductRepository,
        InventoryService $inventoryService
    ) {
        $this->erpProductService = $erpProductService;
        $this->localProductService = $localProductService;
        $this->localProductRepository = $localProductRepository;
        $this->inventoryService = $inventoryService;
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

            $this->log($e);

            throw $e;
        }

    }

    public function importStock($sku)
    {
        try {

            $product = $this->localProductRepository->findOneBySKU($sku);

            if (! $product) {
                throw new IntegrationException(sprintf('The product #%s dont exists.', $sku));
            }

            if (! $product->shouldImportStock()) {
                throw  new IntegrationException(sprintf('The product #%s can not import stock.', $sku));
            }

            $newStock = $this->erpProductService->getStock($sku);

            $this->inventoryService->changeStock($product->getMasterVariant(), $newStock);

            return $newStock;

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

        unset($data['should_import_stock']);
        unset($data['should_import_price']);

        if (! $localProduct->shouldImportStock()) {
            unset($data['stock']);
        }

        if (! $localProduct->shouldImportPrice()) {
            unset($data['price']);
        }

        return $this->localProductService->update($data, $localProduct->getId());
    }

    public function log(Exception $e)
    {
        if ($e instanceof ValidationException) {

            Log::error(sprintf('Validation exception: %s', serialize($e->getErrors())));

        } else {
            Log::error($e->getMessage());
        }
    }

}