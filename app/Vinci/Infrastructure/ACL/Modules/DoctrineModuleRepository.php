<?php

namespace Vinci\Infrastructure\ACL\Modules;

use LaravelDoctrine\ACL\Contracts\HasRoles;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Infrastructure\Common\DoctrineNestedTreeRepository;

class DoctrineModuleRepository extends DoctrineNestedTreeRepository implements ModuleRepository
{

    public function getModulesForUser(HasRoles $user)
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node')
            ->from('Vinci\Domain\ACL\Module\Module', 'node')
            ->join('node.roles', 'r')
            ->orderBy('node.root, node.lft', 'ASC')
            ->where('r.id in (:ids)')
            ->getQuery();

        $ids = $user->getRoles()->map(function($role) {
            return $role->getId();
        });

        $query->setParameter('ids', $ids);

        return $query->getArrayResult();
    }

    public function findByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }

}