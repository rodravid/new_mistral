<?php

namespace Vinci\Domain\Highlight;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Storage\StorageService;

class HighlightService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    public function __construct(
        HighlightRepository $repository,
        EntityManagerInterface $entityManager,
        HighlightValidator $validator,
        StorageService $storage,
        ImageRepository $imageRepository
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->storage = $storage;
        $this->imageRepository = $imageRepository;
    }

    public function create(array $adminData)
    {
        $this->validator->with($adminData)->passesOrFail();

        return $this->saveHighlight($adminData, function($data) {
            return Highlight::make($data);
        });
    }

    public function update(array $adminData, $id)
    {
        $this->validator->with($adminData)->setId($id)->passesOrFail();

        return $this->saveHighlight($adminData, function($data) use ($id) {

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $admin = $this->repository->find($id);
            $admin->fill($data);

            return $admin;
        });
    }

    public function savePhoto(UploadedFile $uploadedPhoto, Highlight $user)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $photo = Image::makeFromUpload($uploadedPhoto, $user->getPhotosUploadPath());

            $this->storage->storeImage($photo);

            $photo = $this->imageRepository->save($photo);

            $user->addPhoto($photo);

            $this->repository->save($user);

            $this->entityManager->getConnection()->commit();

            return $photo;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removePhoto(Image $photo, Highlight $user)
    {
        $user->removePhoto($photo);

        try {

            $this->storage->deleteImage($photo);

            $this->entityManager->remove($photo);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

        } catch (\Exception $e) {

            dd($e->getMessage());

        }
    }

    protected function saveHighlight($adminData, Closure $method)
    {
        $admin = $method($adminData);

        $admin->assignRole($this->entityManager->getReference(Role::class, $adminData['roles']));

        if (! empty($photo = $adminData['photo'])) {
            $photo = $this->savePhoto($photo, $admin);

            $admin->setProfilePhoto($photo);
        }

        $this->repository->save($admin);

        return $admin;
    }

}