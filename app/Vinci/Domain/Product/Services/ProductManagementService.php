<?php

namespace Vinci\Domain\Product\Services;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Events\ProductWasUpdated;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Validators\ProductValidator;

class ProductManagementService
{

    private $entityManager;

    private $repository;

    private $validator;

    private $imageService;

    private $productFactory;

    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $repository,
        ProductValidator $validator,
        ProductImageService $imageService,
        ProductFactory $productFactory,
        Dispatcher $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->imageService = $imageService;
        $this->productFactory = $productFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveProduct($data, function($data) {

            $product = $this->productFactory->make($data);

            return $product;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveProduct($data, function($data) use ($id) {

            $product = $this->repository->find($id);

            $this->productFactory->override($product, $data);

            $event = new ProductWasUpdated($product);

            if (isset($data['user'])) {
                $event->setRaisedByUserInteration(true);
            }

            $product->raise($event);

            return $product;
        });
    }

    protected function saveProduct($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $product = $method($data);

            $this->repository->save($product);

            $this->saveImages($data, $product);

            foreach ($product->releaseEvents() as $event) {
                $this->eventDispatcher->fire($event);
            }

            $this->entityManager->commit();

            return $product;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    public function changePrice(ProductVariantInterface $variant, array $newPrice)
    {
        $currentPrice = $variant->getPrice();
        $newPrice = $newPrice[0];

        if (! empty($price = array_get($newPrice, 'price'))) {
            $currentPrice->setPrice($price);
        }

        if (! empty($currency = array_get($newPrice, 'currency_amount'))) {
            $currentPrice->setCurrencyAmount($currency);
        }

        if (! empty($ipi = array_get($newPrice, 'aliquot_ipi'))) {
            $currentPrice->setAliquotIpi($ipi);
        }

        if (! empty($discountType = array_get($newPrice, 'discount_type'))) {
            $currentPrice->setDiscountType($discountType);
        }

        if (! empty($discountValue = array_get($newPrice, 'discount_value'))) {
            $currentPrice->setDiscountValue($discountType);
        }

        $this->entityManager->persist($currentPrice);
        $this->entityManager->flush();
    }

    protected function saveImages($data, Product $product)
    {
        if (isset($data['image_desktop']) && ! empty($imageDesktop = $data['image_desktop'])) {
            $this->imageService->storeAndAttach($imageDesktop, $product, ImageVersion::DESKTOP);
        }

        if (isset($data['image_mobile']) && ! empty($imageMobile = $data['image_mobile'])) {
            $this->imageService->storeAndAttach($imageMobile, $product, ImageVersion::MOBILE);
        }

        $this->repository->save($product);
    }

}