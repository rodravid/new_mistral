<?php

namespace Vinci\Domain\Admin;

use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class Admin extends User
{

    use \LaravelDoctrine\ORM\Auth\Authenticatable;


    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

}