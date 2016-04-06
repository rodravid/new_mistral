<?php

namespace Vinci\Domain\ACL\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\ACL\Contracts\HasModules;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Permission\Permission;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 */
class Role extends Model implements RoleContract, HasModules
{

    use Timestamps;

    const SUPER_ADMIN = 'super-admin';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

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
        $this->modules = new ArrayCollection;
        $this->permissions = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function assignPermission(Permission $permission)
    {
        if (! $this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }
    }

    public function assignModule(Module $module)
    {
        if (! $this->modules->contains($module)) {
            $this->modules->add($module);
        }
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