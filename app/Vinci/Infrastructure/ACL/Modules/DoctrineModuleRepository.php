<?php

namespace Vinci\Infrastructure\ACL\Modules;

use Doctrine\Common\Collections\Collection;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\ACL\Permission\Permission;
use Vinci\Infrastructure\Common\DoctrineNestedTreeRepository;

class DoctrineModuleRepository extends DoctrineNestedTreeRepository implements ModuleRepository
{

    public function getAll()
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node', 'r', 'p')
            ->from('Vinci\Domain\ACL\Module\Module', 'node')
            ->leftJoin('node.roles', 'r')
            ->leftJoin('r.permissions', 'p')
            ->orderBy('node.root, node.lft', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function getFromRoles(Collection $roles)
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('node', 'r', 'p')
            ->from('Vinci\Domain\ACL\Module\Module', 'node')
            ->join('node.roles', 'r')
            ->join('r.permissions', 'p')
            ->orderBy('node.root, node.lft', 'ASC')
            ->where('r.id in (:ids)')
            ->getQuery();

        $ids = $roles->map(function($role) {
            return $role->getId();
        });

        $query->setParameter('ids', $ids);

        return $query->getResult();
    }

    public function findByName($name)
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('m', 'r', 'p')
            ->from('Vinci\Domain\ACL\Module\Module', 'm')
            ->join('m.roles', 'r')
            ->join('r.permissions', 'p')
            ->where('m.name = :name')
            ->getQuery();

        $query->setParameter('name', $name);

        return $query->getOneOrNullResult();
    }

    public function findByPermissionName($name)
    {
        return $this->findByName($name);
    }

    public function buildTree(array $modules, array $options = [])
    {
        $normalized = [];

        foreach ($modules as $module) {
            $normalized[] = $this->normalizeModule($module);
        }

        return parent::buildTree($normalized, $options);
    }

    protected function normalizeModule($module)
    {
        if (is_array($module)) {
            return $module;
        }

        return [
            'id' => $module->getId(),
            'name' => $module->getName(),
            'title' => $module->getTitle(),
            'url' => $module->getUrl(),
            'icon' => $module->getIcon(),
            'lvl' => $module->getLvl(),
            'lft' => $module->getLft(),
            'rgt' => $module->getRgt()
        ];

    }

}