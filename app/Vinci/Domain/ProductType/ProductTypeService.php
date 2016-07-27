<?php

namespace Vinci\Domain\ProductType;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Infrastructure\Storage\StorageService;

class ProductTypeService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductTypeRepository $repository,
        ProductTypeValidator $validator,
        StorageService $storage,
        ImageRepository $imageRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->storage = $storage;
        $this->imageRepository = $imageRepository;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveProductType($data, function($data) {
            $productType = new ProductType;
            $productType->fill($data);
            return $productType;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveProductType($data, function($data) use ($id) {

            $productType = $this->repository->find($id);
            $productType->fill($data);

            return $productType;
        });
    }

    public function storeImage(ProductType $productType, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $productType->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, ProductType $productType)
    {
        $productType->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($productType);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveProductType($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $productType = $method($data);

            $this->repository->save($productType);

            $this->saveImages($data, $productType);

            $this->repository->save($productType);

            $this->entityManager->commit();

            return $productType;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    protected function saveImages($data, ProductType $productType)
    {
        if (isset($data['picture']) && ! empty($imageDesktop = $data['picture'])) {
            $image = $this->storeImage($productType, $imageDesktop);
            $productType->addImage($image, ImageVersion::PICTURE);
        }

        if (isset($data['picture_mobile']) && ! empty($imageMobile = $data['picture_mobile'])) {
            $image = $this->storeImage($productType, $imageMobile);
            $productType->addImage($image, ImageVersion::PICTURE_MOBILE);
        }
    }

}