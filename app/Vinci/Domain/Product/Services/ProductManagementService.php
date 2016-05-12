<?php

namespace Vinci\Domain\Product\Services;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Builder\ProductBuilder;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory;
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
        \Vinci\Domain\Product\Factories\ProductFactory $productFactory
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

            $this->productFactory->merge($product, $data);

            return $product;
        });
    }

    protected function saveProduct($data, Closure $method)
    {
        $product = $method($data);

//        $this->repository->save($product);
//
//        $this->imageService->storeAndAttach($data['image_desktop'], $product, ImageVersion::DESKTOP);
//        $this->imageService->storeAndAttach($data['image_mobile'], $product, ImageVersion::MOBILE);

        $this->repository->save($product);

        return $product;
    }

}