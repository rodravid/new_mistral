<?php

namespace Vinci\Domain\Payment;

use Illuminate\Support\Facades\Crypt;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Payment\Presenter\CreditCardPresenter;

/**
 * @ORM\Entity
 * @ORM\Table(name="credit_cards")
 */
class CreditCard  extends Model implements CreditCardInterface, Presentable
{
    use Timestampable, PresentableTrait;

    protected $presenter = CreditCardPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $brand;

    /**
     * @ORM\Column(type="string")
     */
    protected $holderName;

    /**
     * @ORM\Column(type="string")
     */
    protected $holderDocument;

    /**
     * @ORM\Column(type="string")
     */
    protected $number;

    /**
     * @ORM\Column(type="string")
     */
    protected $securityCode;

    /**
     * @ORM\Column(type="integer")
     */
    protected $expiryMonth;

    /**
     * @ORM\Column(type="integer")
     */
    protected $expiryYear;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    protected $clean = false;

    public function __toString()
    {
        return $this->getMaskedNumber();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    public function getHolderName()
    {
        return Crypt::decrypt($this->holderName);
    }

    public function setHolderName($holderName)
    {
        $this->holderName = Crypt::encrypt($holderName);
        return $this;
    }

    public function getHolderDocument()
    {
        return $this->holderDocument;
    }

    public function setHolderDocument($holderDocument)
    {
        $this->holderDocument = $holderDocument;
        return $this;
    }

    public function getNumber()
    {
        return Crypt::decrypt($this->number);
    }

    public function setNumber($number)
    {
        $this->number = Crypt::encrypt($number);
        return $this;
    }

    public function getMaskedNumber()
    {
        return sprintf('XXXX XXXX XXXX %s', substr($this->getNumber(), -4));
    }

    public function getSecurityCode()
    {
        return Crypt::decrypt($this->securityCode);
    }

    public function setSecurityCode($securityCode)
    {
        $this->securityCode = Crypt::encrypt($securityCode);
        return $this;
    }

    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }

    public function setExpiryMonth($expiryMonth)
    {
        $this->expiryMonth = $expiryMonth;
        return $this;
    }

    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    public function setExpiryYear($expiryYear)
    {
        $this->expiryYear = $expiryYear;
        return $this;
    }

    public function isClean()
    {
        return $this->clean;
    }

    public function setClean($clean = true)
    {
        $this->clean = (bool) $clean;
        return $this;
    }
}
