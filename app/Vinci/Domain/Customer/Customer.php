<?php

namespace Vinci\Domain\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Auth\Authenticatable;
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
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Order", mappedBy="customer")
     */
    protected $orders;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->orders = new ArrayCollection;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getOrders()
    {
        return $this->orders;
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