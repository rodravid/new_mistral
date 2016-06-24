<?php

namespace Vinci\Domain\Payment;

use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Order\OrderInterface;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Payment\Presenter\PaymentPresenter;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_payments")
 */
class Payment  extends Model implements PaymentInterface, Presentable
{
    use Timestampable, PresentableTrait;

    protected $presenter = PaymentPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Payment\PaymentMethod")
     */
    protected $method;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $amount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $installments = 1;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $installmentAmount = 0;

    /**
     * @ORM\Column(type="string")
     */
    protected $status = PaymentInterface::STATUS_NEW;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Payment\CreditCard", cascade={"persist"})
     */
    protected $creditCard;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Order", inversedBy="payments")
     */
    protected $order;

    public function getId()
    {
        return $this->id;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod(PaymentMethodInterface $method = null)
    {
        $this->method = $method;
        return $this;
    }

    public function setCreditCard(CreditCardInterface $card = null)
    {
        $this->creditCard = $card;
        return $this;
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (double) $amount;

        $this->calcInstallmentAmount();

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;
        return $this;
    }

    public function getInstallments()
    {
        return $this->installments;
    }

    public function setInstallments($installments)
    {
        $this->installments = (int) $installments;

        $this->calcInstallmentAmount();

        return $this;
    }

    public function getInstallmentAmount()
    {
        return $this->installmentAmount;
    }

    public function setInstallmentAmount($installmentAmount)
    {
        $this->installmentAmount = (double) $installmentAmount;
        return $this;
    }

    protected function calcInstallmentAmount()
    {
        $amount = $this->getAmount() / $this->getInstallments();

        $this->setInstallmentAmount($amount);
    }

    public function wasMadeWithCredidCard()
    {
        return $this->getMethod()->getDescription() == 'credit-card';
    }

}