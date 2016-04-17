<?php

namespace Vinci\Domain\Producer;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Infrastructure\Storage\StorageService;

class ProducerService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProducerRepository $repository,
        ProducerValidator $validator,
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

        return $this->saveProducer($data, function($data) {
            $producer = new Producer;
            $producer->fill($data);
            return $producer;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveProducer($data, function($data) use ($id) {

            $producer = $this->repository->find($id);
            $producer->fill($data);

            return $producer;
        });
    }

    public function storeImage(Producer $producer, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $producer->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Producer $producer)
    {
        $producer->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($producer);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveProducer($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $producer = $method($data);

            $this->repository->save($producer);

            $this->saveImages($data, $producer);

            $this->repository->save($producer);

            $this->entityManager->commit();

            return $producer;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    protected function saveImages($data, Producer $producer)
    {
        if (! empty($imageDesktop = $data['image_map'])) {
            $image = $this->storeImage($producer, $imageDesktop);
            $producer->addImage($image, ImageVersion::MAP);
        }

        if (! empty($imageMobile = $data['image_banner'])) {
            $image = $this->storeImage($producer, $imageMobile);
            $producer->addImage($image, ImageVersion::BANNER);
        }
    }

}