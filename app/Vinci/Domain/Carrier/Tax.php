<?php

namespace Vinci\Domain\Carrier;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="carriers_metrics_taxes")
 */
class Tax implements TaxInterface
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Carrier\CarrierMetric", inversedBy="taxes")
     */
    protected $carrierMetric;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $amount;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (double) $amount;
        return $this;
    }

    public function getCarrierMetric()
    {
        return $this->carrierMetric;
    }

    public function setCarrierMetric(CarrierMetric $carrierMetric)
    {
        $this->carrierMetric = $carrierMetric;
        return $this;
    }

    public function apply(&$amount)
    {

       switch (self::getType()) {

           case self::TYPE_FIXED:
               $amount += $this->getAmount();

               break;

           case self::TYPE_PERCENTAGE:

               $amount = $amount + ($amount * $this->getAmount() / 100);

               break;
       }

    }

}