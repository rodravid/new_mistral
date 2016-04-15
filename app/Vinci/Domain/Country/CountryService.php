<?php

namespace Vinci\Domain\Country;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Infrastructure\Storage\StorageService;

class CountryService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    private $aclService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CountryRepository $repository,
        CountryValidator $validator,
        StorageService $storage,
        ImageRepository $imageRepository,
        ACLService $aclService
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->storage = $storage;
        $this->imageRepository = $imageRepository;
        $this->aclService = $aclService;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveCountry($data, function($data) {

            $country = new Country;
            $country->setScheduleFieldsFromArray($data);
            $country->fill($data);

            return $country;

        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveCountry($data, function($data) use ($id) {

            $country = $this->repository->find($id);
            $country->setScheduleFieldsFromArray($data);
            $country->fill($data);

            return $country;
        });
    }

    public function storeImage(Country $country, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $country->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Country $country)
    {
        $country->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($country);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveCountry($data, Closure $method)
    {
        $country = $method($data);

        $country->setType($this->aclService->getCurrentModuleName());

        $this->repository->save($country);

        if (! empty($imageDesktop = $data['image_desktop'])) {
            $image = $this->storeImage($country, $imageDesktop);
            $country->addImage($image, ImageVersion::DESKTOP);
        }

        if (! empty($imageMobile = $data['image_mobile'])) {
            $image = $this->storeImage($country, $imageMobile);
            $country->addImage($image, ImageVersion::MOBILE);
        }

        $this->repository->save($country);

        return $country;
    }

}