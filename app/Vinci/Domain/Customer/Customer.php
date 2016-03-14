<?php

namespace Vinci\Domain\Customer;

use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use Vinci\Domain\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer extends User
{

    use Authenticatable;

    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;


    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

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