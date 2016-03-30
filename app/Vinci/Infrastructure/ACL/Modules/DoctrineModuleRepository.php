<?php

namespace Vinci\Infrastructure\ACL\Modules;

use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\Admin\Admin;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineModuleRepository extends DoctrineBaseRepository implements ModuleRepository
{

    public function findModulesForAdminUser(Admin $user)
    {
        $query = $this->_em->createQuery("SELECT m FROM \Vinci\Domain\ACL\Module\Module m JOIN m.roles r WHERE r.id IN (:ids)");

        $ids = $user->getRoles()->map(function($role) {
            return $role->getId();
        });

        $query->setParameter('ids', $ids);

        return $query->getResult();
    }
}