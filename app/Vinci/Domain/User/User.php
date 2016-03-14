<?php

namespace Vinci\Domain\User;

use Carbon\Carbon;

use Illuminate\Contracts\Auth\Authenticatable;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Contracts\Auth\CanResetPassword;
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

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    public function setCreatedAt(Carbon $date)
    {
        $this->created_at = $date;
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

}