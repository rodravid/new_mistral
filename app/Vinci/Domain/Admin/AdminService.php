<?php

namespace Vinci\Domain\Admin;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Validation\ValidationException;

class AdminService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    public function __construct(
        AdminRepository $repository,
        EntityManagerInterface $entityManager,
        AdminValidator $validator
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function create(array $adminData)
    {
        if ($this->validator->fails($adminData)) {
            throw new ValidationException('Não foi possível criar o usuário', $this->validator->messages());
        }

        return $this->saveAdmin($adminData, function($data) {
            return Admin::make($data);
        });
    }

    public function update(array $adminData, $id)
    {
        if ($this->validator->fails($adminData, $id)) {
            throw new ValidationException('Não foi possível atualizar o usuário', $this->validator->messages());
        }

        return $this->saveAdmin($adminData, function($data) use ($id) {

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $admin = $this->repository->find($id);
            $admin->fill($data);

            return $admin;
        });
    }

    public function savePhoto(UploadedFile $photo, Admin $user)
    {



    }

    protected function saveAdmin($adminData, Closure $method)
    {
        $admin = $method($adminData);

        $admin->assignRole($this->entityManager->getReference(Role::class, $adminData['roles']));

        $this->repository->save($admin);

        return $admin;
    }

}