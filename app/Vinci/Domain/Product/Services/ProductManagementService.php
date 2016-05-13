<?php

namespace Vinci\Domain\Product\Services;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Validators\ProductValidator;

class ProductManagementService
{
    use ValidationTrait;

    private $entityManager;

    private $repository;

    private $validator;

    private $imageService;

    private $productFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $repository,
        ProductValidator $validator,
        ProductImageService $imageService,
        ProductFactory $productFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->imageService = $imageService;
        $this->productFactory = $productFactory;
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

            $this->entityManager->commit();

            return $product;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
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