<?php

namespace Vinci\Domain\Customer;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Hash;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;
use Vinci\Domain\Auth\Authenticatable;
use Vinci\Domain\Common\Traits\HasIntegrationStatus;
use Vinci\Domain\Customer\Address\Address;
use Vinci\Domain\Customer\Events\CustomerPasswordWasChanged;
use Vinci\Domain\Customer\Events\CustomerWasCreated;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;
use Vinci\Domain\User\User;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Customer\DoctrineCustomerRepository")
 * @ORM\Table(name="customers", indexes={@ORM\Index(name="customer_type_idx", columns={"customer_type"})})
 */
class Customer extends User implements CustomerInterface, Presentable
{
    use Authenticatable, PresentableTrait, HasIntegrationStatus;

    protected $presenter = CustomerPresenter::class;

    /**
     * @ORM\Column(name="import_id", type="integer", nullable=true)
     */
    protected $importId;

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
     * @ORM\Column(name="company_contact", type="string", nullable=true)
     */
    protected $companyContact;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cnpj;

    /**
     * @ORM\Column(name="state_registration", type="string", nullable=true)
     */
    protected $stateRegistration;

    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true}, nullable=true)
     */
    protected $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $birthday;

    /**
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cryptKey;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Customer\Address\Address",
     *     mappedBy="customer",
     *     indexBy="id",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\ShoppingCart\ShoppingCart", mappedBy="customer", cascade={"persist", "remove"})
     */
    protected $shoppingCarts;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Product", inversedBy="customers")
     * @ORM\JoinTable(name="products_favorites")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $favoriteProducts;

    public function __construct()
    {
        parent::__construct();

        $this->orders = new ArrayCollection;
        $this->addresses = new ArrayCollection;
        $this->shoppingCarts = new ArrayCollection;
        $this->favoriteProducts = new ArrayCollection;

        $this->raise(new CustomerWasCreated($this));
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

    public function setCpf($cpf = null)
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getCpf()
    {
        return only_numbers($this->cpf);
    }

    public function setCnpj($cnpj = null)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getCnpj()
    {
        return only_numbers($this->cnpj);
    }

    public function setRg($rg = null)
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

    public function setStateRegistration($stateRegistration = null)
    {
        $this->stateRegistration = $stateRegistration;
        return $this;
    }

    public function getIssuingBody()
    {
        return $this->issuingBody;
    }

    public function setIssuingBody($issuingBody = null)
    {
        $this->issuingBody = $issuingBody;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender = null)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday(Carbon $birthday = null)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone = null)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    public function setCellPhone($cellPhone = null)
    {
        $this->cellPhone = $cellPhone;
        return $this;
    }

    public function hasCellPhone()
    {
        return !empty($this->cellPhone);
    }

    public function getCommercialPhone()
    {
        return $this->commercialPhone;
    }

    public function setCommercialPhone($commercialPhone = null)
    {
        $this->commercialPhone = $commercialPhone;
        return $this;
    }

    public function hasCommercialPhone()
    {
        return !empty($this->commercialPhone);
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName = null)
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

    public function setPassword($password)
    {
        if (! Hash::check($password, $this->password)) {

            $this->password = bcrypt($password);

            if (! empty($this->id)) {
                $this->raise(new CustomerPasswordWasChanged($this));
            }

        }
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
        if (!$this->addresses->containsKey($address->getId())) {
            $address->setCustomer($this);
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddress($address)
    {
        if ($address instanceof Address) {
            return $this->addresses->remove($address->getId());
        }

        return $this->addresses->remove($address);
    }

    public function syncAddress(ArrayCollection $addresses)
    {
        $toRemove = $this->addresses->filter(function ($address) use ($addresses) {
            if ($addresses->contains($address)) {
                return false;
            }

            return true;
        });

        foreach ($toRemove as $address) {
            $this->addresses->remove($address->getId());
        }

        foreach ($addresses as $address) {

            if ($this->addresses->containsKey($address->getId())) {
                $this->addresses->set($address->getId(), $address);
            } else {
                $this->addresses->add($address);
            }
        }

    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAddresses(ArrayCollection $addresses)
    {
        $this->addresses = $addresses;
        return $this;
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
        foreach ($this->addresses as $address) {
            if ($address->isMainAddress()) {
                return $address;
            }
        }
    }

    public function setMainAddress(Address $mainAddress)
    {
        foreach ($this->addresses as $address) {
            $address->setMainAddress(false);
        }

        $mainAddress->setCustomer($this);
        $mainAddress->setMainAddress(true);

        return $this;
    }

    public function hasMainAddress()
    {
        return $this->getMainAddress() instanceof Address;
    }

    public function getCompanyContact()
    {
        return $this->companyContact;
    }

    public function setCompanyContact($companyContact = null)
    {
        $this->companyContact = $companyContact;
        return $this;
    }

    public function getShoppingCarts()
    {
        return $this->shoppingCarts;
    }

    public function addShoppingCart(ShoppingCartInterface $shoppingCart)
    {
        if (!$this->shoppingCarts->contains($shoppingCart)) {
            $shoppingCart->setCustomer($this);

            if ($this->shoppingCarts->isEmpty()) {
                $shoppingCart->setCurrent(true);
            }

            $this->shoppingCarts->add($shoppingCart);
        }
    }

    public function hasShoppingCart(ShoppingCartInterface $shoppingCart)
    {
        return $this->shoppingCarts->contains($shoppingCart);
    }

    public function getImportId()
    {
        return $this->importId;
    }

    public function setImportId($importId)
    {
        $this->importId = $importId;
        return $this;
    }

    public function addProductToFavorites(ProductInterface $product)
    {
        if (!$this->isInFavorites($product)) {
            $this->favoriteProducts->add($product);
        }
    }

    public function removeProductFromFavorites(ProductInterface $product)
    {
        if ($this->isInFavorites($product)) {
            $this->favoriteProducts->removeElement($product);
        }
    }

    public function isInFavorites(ProductInterface $product)
    {
        return $this->favoriteProducts->contains($product);
    }

    public function getCryptKey()
    {
        return $this->cryptKey;
    }

    public function setCryptKey($cryptKey = null)
    {
        $this->cryptKey = $cryptKey;
        return $this;
    }

    public function clearCryptKey()
    {
        return $this->setCryptKey(null);
    }

    public function isOldCustomer()
    {
        return ! empty($this->getCryptKey());
    }

}