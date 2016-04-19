<?php

namespace Vinci\Infrastructure\ACL\Permissions;

use Vinci\Domain\ACL\Permission\PermissionRepository;
use Vinci\Infrastructure\Cache\Traits\ArrayCache;

class DoctrinePermissionRepositoryCached extends DoctrinePermissionRepository implements PermissionRepository
{

    use ArrayCache;

    public function getAll()
    {
        return $this->cache('all', function() {
            return parent::getAll();
        });
    }

    public function findByName($name)
    {
        return $this->cache('by_name' . $name, function() use($name) {

            foreach ($this->getAll() as $permission) {

                if ($permission->getName() == $name) {
                    return $permission;
                }
            }
        });
    }
}