<?php

namespace Vinci\Domain\ACL;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Permission;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;

/**
 * @ORM\Entity()
 */
class Role implements RoleContract
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        // TODO: Implement hasPermissionTo() method.
    }

    /**
     * @return ArrayCollection|Permission[]
     */
    public function getPermissions()
    {
        // TODO: Implement getPermissions() method.
    }
}