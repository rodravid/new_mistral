<?php

namespace Vinci\Domain\Payment;

use Doctrine\ORM\Mapping as ORM;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Payment\Presenter\PaymentMethodPresenter;

/**
 * @ORM\Entity
 * @ORM\Table(name="payment_methods")
 */
class PaymentMethod extends Model implements PaymentMethodInterface, Presentable
{

    use Timestampable, PresentableTrait;
    
    protected $presenter = PaymentMethodPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="code", type="string", nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="gateway", type="string", nullable=true)
     */
    protected $gateway;

    /**
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status = Status::ACTIVE;

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getGateway()
    {
        return $this->gateway;
    }

    public function setGateway($gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function isCreditCard()
    {
        return $this->description == self::CREDIT_CARD;
    }

    public function isBankDeposit()
    {
        return $this->description == self::BANK_DEPOSIT;
    }

}