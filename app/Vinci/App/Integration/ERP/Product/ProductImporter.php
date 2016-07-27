<?php

namespace Vinci\App\Integration\ERP\Product;

use Exception;
use Illuminate\Support\Str;
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

        } catch (ValidationException $e) {

            $this->log($e, $sku, $erpProduct);

            throw new IntegrationException(sprintf('Validation exception #%s: %s', $sku, serialize($e->getErrors())));

        } catch (Exception $e) {

            $this->log($e, $sku);

            throw $e;
        } finally {
            app('em')->clear();
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
                throw new IntegrationException(sprintf('The product #%s can not import stock.', $sku));
            }

            $newStock = $this->erpProductService->getStock($sku);

            $this->inventoryService->changeStock($product->getMasterVariant(), $newStock);

            return $newStock;

        } catch (Exception $e) {

            $this->log($e, $sku);

            throw $e;
        } finally {
            app('em')->clear();
        }
    }

    public function importPrice($sku)
    {
        try {

            $product = $this->localProductRepository->findOneBySKU($sku);

            if (! $product) {
                throw new IntegrationException(sprintf('The product #%s dont exists.', $sku));
            }

            if (! $product->shouldImportPrice()) {
                throw new IntegrationException(sprintf('The product #%s can not import price.', $sku));
            }

            $newPrice = $this->erpProductService->getPrice($sku);

            $this->localProductService->changePrice($product->getMasterVariant(), $newPrice);

            return $newPrice;

        } catch (Exception $e) {

            $this->log($e, $sku);

            throw $e;

        } finally {
            app('em')->clear();
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

    public function log(Exception $e, $sku, $erpProduct = null)
    {
        if ($e instanceof ValidationException) {

            $firstError = $e->getErrors()->first();

            if (Str::contains($firstError, 'country')) {
                $message = sprintf('Páis não existe: %s - %s', $erpProduct->country_id, $erpProduct->country_name);
            } else if (strpos($firstError, 'region') !== false) {
                $message = sprintf('Região não existe: %s - %s', $erpProduct->region_id, $erpProduct->region_name);
            } else if (strpos($firstError, 'producer') !== false) {
                $message = sprintf('Produtor não existe: %s - %s', $erpProduct->producer_id, $erpProduct->producer_name);
            } else if (strpos($firstError, 'type') !== false) {
                $message = sprintf('Tipo de produto não existe: %s - %s', $erpProduct->product_type_id, $erpProduct->product_type_name);
            } else {
                $message = serialize($e->getErrors());
            }

            file_put_contents(
                storage_path('/app/products_integration_errors.txt'),
                sprintf('%s: %s', $sku, $message) . PHP_EOL,
                FILE_APPEND
            );

            Log::error(sprintf('Validation exception #%s: %s', $sku, serialize($e->getErrors())));

        } else {

            file_put_contents(
                storage_path('/app/products_integration_errors.txt'),
                sprintf('%s: %s', $sku, $e->getMessage()) . PHP_EOL,
                FILE_APPEND
            );

            Log::error($e->getMessage());
        }
    }

}