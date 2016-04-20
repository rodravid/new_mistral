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
    protected $rg;

    /**
     * @ORM\Column(name="issuing_body", type="string", nullable=true)
     */
    protected $issuingBody;

    /**
     * @ORM\Column(name="company_name", type="string", nullable=true)
     */
    protected $companyName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cnpj;

    /**
     * @ORM\Column(name="state_registration", type="string", nullable=true)
     */
    protected $stateRegistration;

    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    protected $gender;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthday;

    /**
     * @ORM\Column(name="phone", type="string", length=20)
     */
    protected $phone;

    /**
     * @ORM\Column(name="cell_phone", type="string", length=20, nullable=true)
     */
    protected $cellPhone;

    /**
     * @ORM\Column(name="commercial_phone", type="string", length=20, nullable=true)
     */
    protected $commercialPhone;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Customer\Address\Address", mappedBy="customer")
     */
    protected $addresses;

    /**
     * @ORM\OneToOne(targetEntity="Vinci\Domain\Customer\Address\Address")
     * @ORM\JoinColumn(name="main_address")
     */
    protected $mainAddress;

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

    public function getIssuingBody()
    {
        return $this->issuingBody;
    }

    public function setIssuingBody($issuingBody)
    {
        $this->issuingBody = $issuingBody;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }


    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
        return $this;
    }

    public function hasCellPhone()
    {
        return ! empty($this->cellPhone);
    }

    public function getCommercialPhone()
    {
        return $this->commercialPhone;
    }

    public function setCommercialPhone($commercialPhone)
    {
        $this->commercialPhone = $commercialPhone;
        return $this;
    }

    public function hasCommercialPhone()
    {
        return ! empty($this->commercialPhone);
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
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

    public function getCustomerType()
    {
        return $this->customerType;
    }

    public function setCustomerType($customerType)
    {
        $this->customerType = $customerType;
        return $this;
    }

    public function stats()
    {
        return new Stats($this);
    }

    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    public function setMainAddress(Address $mainAddress)
    {
        $this->mainAddress = $mainAddress;
        return $this;
    }

    public function hasMainAddress()
    {
        return $this->mainAddress instanceof Address;
    }

}