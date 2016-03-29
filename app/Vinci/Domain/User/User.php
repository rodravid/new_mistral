<?php

namespace Vinci\Domain\User;

use Carbon\Carbon;

use Illuminate\Contracts\Auth\Authenticatable;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\CanResetPassword;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"customer" = "Vinci\Domain\Customer\Customer", "admin" = "Vinci\Domain\Admin\Admin"})
 */
abstract class User extends Model implements Authenticatable, CanResetPassword
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

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

    public function setPassword($password)
    {
        $this->password = bcrypt($password);
    }

}