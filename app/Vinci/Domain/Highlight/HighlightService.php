<?php

namespace Vinci\Domain\Highlight;

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

class HighlightService
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
        HighlightRepository $repository,
        HighlightValidator $validator,
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

        return $this->saveHighlight($data, function($data) {

            $highlight = new Highlight;
            $highlight->setScheduleFieldsFromArray($data);
            $highlight->fill($data);

            return $highlight;

        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveHighlight($data, function($data) use ($id) {

            $highlight = $this->repository->find($id);
            $highlight->setScheduleFieldsFromArray($data);
            $highlight->fill($data);

            return $highlight;
        });
    }

    public function storeImage(Highlight $highlight, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $highlight->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Highlight $highlight)
    {
        $highlight->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($highlight);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveHighlight($data, Closure $method)
    {
        $highlight = $method($data);

        $highlight->setType($this->aclService->getCurrentModuleName());

        $this->repository->save($highlight);

        if (! empty($imageDesktop = $data['image_desktop'])) {
            $image = $this->storeImage($highlight, $imageDesktop);
            $highlight->addImage($image, ImageVersion::DESKTOP);
        }

        if (! empty($imageMobile = $data['image_mobile'])) {
            $image = $this->storeImage($highlight, $imageMobile);
            $highlight->addImage($image, ImageVersion::MOBILE);
        }

        $this->repository->save($highlight);

        return $highlight;
    }

}