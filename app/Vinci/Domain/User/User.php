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
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Image\Image;
use Vinci\Domain\User\Contracts\HasSettings;
use Vinci\Domain\User\Settings\Settings;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={@ORM\Index(name="user_type_idx", columns={"type"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="smallint")
 * @ORM\DiscriminatorMap({UserType::CUSTOMER = "Vinci\Domain\Customer\Customer", UserType::ADMIN = "Vinci\Domain\Admin\Admin"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class User extends Model implements
    Authenticatable,
    AuthorizableContract,
    CanResetPassword,
    HasRolesContract,
    HasPermissionsContract,
    HasSettings
{

    use Timestamps, SoftDeletes, HasRoles, HasPermissions, Authorizable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    protected $status = 0;

    /**
     * @ACL\HasRoles(inversedBy=null)
     */
    protected $roles;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Image\Image")
     * @ORM\JoinTable(name="users_photos",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id", unique=true)}
     *     )
     */
    protected $photos;

    /**
     * @ORM\OneToOne(targetEntity="Vinci\Domain\Image\Image", fetch="EAGER")
     */
    protected $profile_photo;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    protected $settings;

    public function __construct()
    {
        $this->roles = new ArrayCollection;
        $this->photos = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
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

    public function addPhoto(Image $photo)
    {
        if (! $this->photos->contains($photo)) {
            $this->photos->add($photo);
        }
    }

    public function removePhoto(Image $photo)
    {
        if ($this->getProfilePhoto() == $photo) {
            $this->removeProfilePhoto();
        }

        $this->photos->removeElement($photo);
    }

    public function removeProfilePhoto()
    {
        $this->profile_photo = null;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function hasPermissionTo($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($this->getPermissions() as $per) {
            if ($per->getName() == $permission) {
                return true;
            }
        }

        return false;
    }

    public function canManageModule($moduleName)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        foreach ($this->roles as $role) {
            foreach ($role->getModules() as $module) {
                if ($module->getName() == $moduleName) {
                    return true;
                }
            }
        }

        return false;
    }

    public function cannotManageModule($module)
    {
        return ! $this->canManageModule($module);
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

    public function setProfilePhoto(Image $photo)
    {
        $this->profile_photo = $photo;
    }

    public function getProfilePhoto()
    {
        return $this->profile_photo;
    }

    public function hasProfilePhoto()
    {
        return ! empty($this->profile_photo);
    }

    public function getPhotosUploadPath()
    {
        return 'users/' . $this->getId() . '/photos';
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function settings($key = null, $value = null)
    {
        $settings = new Settings($this);

        if (is_null($key)) {
            return $settings;

        } elseif (is_null($value)) {
            return $settings->get($key);
        }

        $settings->set($key, $value);

        return $this;
    }

    public function isCustomer()
    {
        return $this instanceof Customer;
    }

}