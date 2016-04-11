<?php

namespace Vinci\Domain\Admin;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Infrastructure\Storage\StorageService;

class AdminService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    public function __construct(
        AdminRepository $repository,
        EntityManagerInterface $entityManager,
        AdminValidator $validator,
        StorageService $storage
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->storage = $storage;
    }

    public function create(array $adminData)
    {

        $this->validator->with($adminData)->passesOrFail();

        if ($this->validator->fails($adminData)) {
            throw new ValidationException('Não foi possível criar o usuário', $this->validator->messages());
        }

        return $this->saveAdmin($adminData, function($data) {
            return Admin::make($data);
        });
    }

    public function update(array $adminData, $id)
    {
        $this->validator->with($adminData)->setId($id)->passesOrFail();

        return $this->saveAdmin($adminData, function($data) use ($id) {

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $admin = $this->repository->find($id);
            $admin->fill($data);

            return $admin;
        });
    }

    public function savePhoto(UploadedFile $uploadedPhoto, Admin $user)
    {
        //$this->entityManager->getConnection()->beginTransaction();

        //dd($uploadedPhoto);

        //try {

            $photo = Image::makeFromUpload($uploadedPhoto);
            $photoMobile = Image::makeFromUpload($uploadedPhoto);

            $photo->setPath($user->getPhotosUploadPath());
            $photo->setSmall($photoMobile);

            $this->entityManager->persist($photo);
            $this->entityManager->flush();

            $this->storage->storeImage($photo);

            dd($photo->getSmall()->getPathName());

            dd($photo->getUploadPathName());

            //$photoMobile->setPath($photoDesktop->getPath() . '_small');

            $photoDesktop->setSmall($photoMobile);

            $photoDesktop->setPath("users/{$user->getId()}/photo");

            $user->addPhoto($photo);
            $user->setProfilePhoto($photo);

            $this->entityManager->persist($photo);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->storage->storePhoto($photoDesktop);
            $this->storage->storePhoto($photoMobile);

        //} catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
        //    throw $e;
        //}
    }

    protected function saveAdmin($adminData, Closure $method)
    {
        $admin = $method($adminData);

        $admin->assignRole($this->entityManager->getReference(Role::class, $adminData['roles']));

        $this->repository->save($admin);

        return $admin;
    }

}