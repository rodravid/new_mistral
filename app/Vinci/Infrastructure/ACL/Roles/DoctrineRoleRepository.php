<?php

namespace Vinci\Infrastructure\ACL\Roles;

use Vinci\Domain\ACL\Role\RoleRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineRoleRepository extends DoctrineBaseRepository implements RoleRepository
{

    public function getAll()
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('role')
            ->from('Vinci\Domain\ACL\Role\Role', 'role')
            ->getQuery();

        return $query->getResult();
    }

}