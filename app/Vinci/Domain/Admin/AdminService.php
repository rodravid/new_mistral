<?php

namespace Vinci\Domain\Admin;

use Doctrine\ORM\EntityManagerInterface;
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

        $admin = Admin::make($adminData);

        $admin->assignRole($this->entityManager->getReference(Role::class, $adminData['roles']));

        $this->repository->save($admin);

        return $admin;
    }

    public function update(array $adminData, $id)
    {
        if ($this->validator->fails($adminData, $id)) {
            throw new ValidationException('Não foi possível criar o usuário', $this->validator->messages());
        }

        $admin = $this->repository->find($id);

        $admin->assignRole($this->entityManager->getReference(Role::class, $adminData['roles']));

        $admin->fill($adminData);

        $this->repository->save($admin);

        return $admin;
    }

}