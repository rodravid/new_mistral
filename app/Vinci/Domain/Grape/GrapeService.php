<?php

namespace Vinci\Domain\Grape;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Infrastructure\Storage\StorageService;

class GrapeService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        GrapeRepository $repository,
        GrapeValidator $validator,
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

        return $this->saveGrape($data, function($data) {
            $grape = new Grape;
            $grape->fill($data);
            return $grape;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveGrape($data, function($data) use ($id) {

            $grape = $this->repository->find($id);
            $grape->fill($data);

            return $grape;
        });
    }

    public function storeImage(Grape $grape, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $grape->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Grape $grape)
    {
        $grape->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($grape);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveGrape($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $grape = $method($data);

            $this->repository->save($grape);

            $this->saveImages($data, $grape);

            $this->repository->save($grape);

            $this->entityManager->commit();

            return $grape;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    protected function saveImages($data, Grape $grape)
    {
        if (! empty($imageDesktop = $data['picture'])) {
            $image = $this->storeImage($grape, $imageDesktop);
            $grape->addImage($image, ImageVersion::PICTURE);
        }

        if (! empty($imageMobile = $data['picture_mobile'])) {
            $image = $this->storeImage($grape, $imageMobile);
            $grape->addImage($image, ImageVersion::PICTURE_MOBILE);
        }
    }

}