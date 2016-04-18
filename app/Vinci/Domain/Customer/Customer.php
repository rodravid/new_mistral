<?php

namespace Vinci\Domain\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Auth\Authenticatable;
use Vinci\Domain\Customer\Address\Address;
use Vinci\Domain\User\User;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Customer\DoctrineCustomerRepository")
 * @ORM\Table(name="customers", indexes={@ORM\Index(name="customer_type_idx", columns={"customer_type"})})
 */
class Customer extends User
{

    use Authenticatable;

    /**
     * @ORM\Column(name="customer_type", type="smallint")
     */
    protected $customerType;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cpf;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cnpj;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $rg;

    /**
     * @ORM\Column(name="state_registration", type="string", nullable=true)
     */
    protected $stateRegistration;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @ORM\OneToOne(targetEntity="Vinci\Domain\Customer\Address\Address", mappedBy="customer")
     */
    protected $addresses;

    public function __construct()
    {
        parent::__construct();

        $this->orders = new ArrayCollection;
        $this->addresses = new ArrayCollection;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setRg($rg)
    {
        $this->rg = $rg;
        return $this;
    }

    public function getRg()
    {
        return $this->rg;
    }

    public function getStateRegistration()
    {
        return $this->stateRegistration;
    }

    public function setStateRegistration($stateRegistration)
    {
        $this->stateRegistration = $stateRegistration;
        return $this;
    }

    public function getDocument()
    {
        if ($this->isIndividual()) {
            return $this->getCpf();
        }

        return $this->getCnpj();
    }

    public function getRegistry()
    {
        if ($this->isIndividual()) {
            return $this->getRg();
        }

        return $this->getStateRegistration();
    }

    public function isIndividual()
    {
        return $this->customerType == CustomerType::INDIVIDUAL;
    }

    public function isCompany()
    {
        return $this->customerType == CustomerType::COMPANY;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function addAddress(Address $address)
    {
        if (! $this->addresses->contains($address)) {
            $this->addresses->add($address);
        }

        return $this;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

}