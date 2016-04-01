<?php

namespace Vinci\Domain\ACL\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use Vinci\Domain\ACL\Contracts\HasModules;

/**
 * @ORM\Entity
 */
class Role implements RoleContract, HasModules
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
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\ACL\Module\Module", inversedBy="roles")
     * @ORM\JoinTable(name="roles_modules")
     */
    protected $modules;

    /**
     * @ACL\HasPermissions
     */
    public $permissions;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

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

    public function getModules()
    {
        return $this->modules;
    }

    public function hasPermissionTo($permission)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->getName() == $permission) {
                return true;
            }
        }

        return false;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

}