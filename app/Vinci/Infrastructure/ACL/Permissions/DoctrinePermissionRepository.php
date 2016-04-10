<?php

namespace Vinci\Infrastructure\ACL\Permissions;

use Vinci\Domain\ACL\Permission\PermissionRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrinePermissionRepository extends DoctrineBaseRepository implements PermissionRepository
{

    public function getAll()
    {
        return $this->createQueryBuilder('o')->getQuery()->getResult();
    }

    public function findByName($name)
    {
        return $this->findBy(['name' => $name]);
    }
}