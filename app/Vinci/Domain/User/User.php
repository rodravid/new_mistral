<?php

namespace Vinci\Domain\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsContract;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\ACL\Roles\HasRoles;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"customer" = "Vinci\Domain\Customer\Customer", "admin" = "Vinci\Domain\Admin\Admin"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class User extends Model implements Authenticatable, AuthorizableContract, CanResetPassword, HasRolesContract, HasPermissionsContract
{

    use Timestamps, SoftDeletes, HasRoles, HasPermissions, Authorizable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ACL\HasRoles()
     * @var \Doctrine\Common\Collections\ArrayCollection|\LaravelDoctrine\ACL\Contracts\Role[]
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function assignRole(Role $role)
    {
        $this->roles->clear();
        $this->roles->add($role);
    }

    public function hasPermissionTo($permission)
    {
        foreach ($this->getPermissions() as $per) {
            if ($per->getName() == $permission) {
                return true;
            }
        }

        return false;
    }

    public function getPermissions()
    {
        $permissions = new ArrayCollection;

        foreach ($this->roles as $role) {
            foreach ($role->getPermissions() as $permission) {
                if (! $permissions->contains($permission)) {
                    $permissions->add($permission);
                }
            }
        }

        return $permissions;
    }

    public function isSuperAdmin()
    {
        return $this->hasRoleByName(Role::SUPER_ADMIN);
    }

}