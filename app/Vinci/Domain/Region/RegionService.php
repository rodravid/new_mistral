<?php

namespace Vinci\Domain\Region;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Infrastructure\Storage\StorageService;

class RegionService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RegionRepository $repository,
        RegionValidator $validator,
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

        return $this->saveRegion($data, function($data) {
            $region = new Region;
            $region->fill($data);
            return $region;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveRegion($data, function($data) use ($id) {

            $region = $this->repository->find($id);
            $region->fill($data);

            return $region;
        });
    }

    public function storeImage(Region $region, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $region->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Region $region)
    {
        $region->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($region);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveRegion($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $region = $method($data);

            $region->setCountry($this->entityManager->getReference(Country::class, $data['country']));

            $this->repository->save($region);

            $this->saveImages($data, $region);

            $this->repository->save($region);

            $this->entityManager->commit();

            return $region;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    protected function saveImages($data, Region $region)
    {
        if (! empty($imageDesktop = $data['image_map'])) {
            $image = $this->storeImage($region, $imageDesktop);
            $region->addImage($image, ImageVersion::MAP);
        }

        if (! empty($imageMobile = $data['image_banner'])) {
            $image = $this->storeImage($region, $imageMobile);
            $region->addImage($image, ImageVersion::BANNER);
        }
    }

}