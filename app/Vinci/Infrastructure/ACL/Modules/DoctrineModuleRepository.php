<?php

namespace Vinci\Infrastructure\ACL\Modules;

use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\HasRoles;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Infrastructure\Common\DoctrineNestedTreeRepository;

class DoctrineModuleRepository extends DoctrineNestedTreeRepository implements ModuleRepository
{

    public function findModulesForUser(HasRoles $user)
    {
        if ($user->getRoles()->count()) {

            $query = $this->_em->createQuery("SELECT m, ch FROM \Vinci\Domain\ACL\Module\Module m LEFT JOIN m.children ch JOIN m.roles r WHERE r.id IN (:ids)");

            $ids = $user->getRoles()->map(function($role) {
                return $role->getId();
            });

            $query->setParameter('ids', $ids);

            return $query->getResult();
        }

        return new ArrayCollection;
    }

}