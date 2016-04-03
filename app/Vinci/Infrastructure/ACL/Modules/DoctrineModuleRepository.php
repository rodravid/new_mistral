<?php

namespace Vinci\Infrastructure\ACL\Modules;

use Doctrine\Common\Collections\ArrayCollection;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Infrastructure\Common\DoctrineNestedTreeRepository;

class DoctrineModuleRepository extends DoctrineNestedTreeRepository implements ModuleRepository
{

    public function getAll()
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node')
            ->from('Vinci\Domain\ACL\Module\Module', 'node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function getFromRoles(ArrayCollection $roles)
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node')
            ->from('Vinci\Domain\ACL\Module\Module', 'node')
            ->join('node.roles', 'r')
            ->orderBy('node.root, node.lft', 'ASC')
            ->where('r.id in (:ids)')
            ->getQuery();

        $ids = $roles->map(function($role) {
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