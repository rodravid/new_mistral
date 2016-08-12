<?php

namespace Vinci\Domain\Payment;

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
        return $this->holderName;
    }

    public function setHolderName($holderName)
    {
        $this->holderName = $holderName;
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
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    public function getMaskedNumber()
    {
        return sprintf('XXXX XXXX XXXX %s', substr($this->getNumber(), -4));
    }

    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
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
}
