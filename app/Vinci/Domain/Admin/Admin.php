<?php

namespace Vinci\Domain\Admin;

use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Auth\Authenticatable;
use Vinci\Domain\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class Admin extends User
{

    use Authenticatable;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

}