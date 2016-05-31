<?php

namespace Vinci\Domain\Carrier;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Shipping\Calculator\ShippingCalculatorInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="carriers")
 */
class Carrier implements CarrierInterface
{

    use Timestampable, SoftDeletes;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    protected $defaultCarrier = false;

    /**
     * @ORM\Column(type="string")
     */
    protected $shippingCalculator = ShippingCalculatorInterface::DEFAULT_CALCULATOR;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Carrier\CarrierMetric", mappedBy="carrier", cascade={"persist"})
     */
    protected $metrics;

    public function __construct()
    {
        $this->metrics = new ArrayCollection;
    }
    
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

    public function getShippingCalculator()
    {
        return $this->shippingCalculator;
    }

    public function setShippingCalculator($calculator)
    {
        $this->shippingCalculator = $calculator;
        return $this;
    }

    public function getMetrics()
    {
        return $this->metrics;
    }

    public function getMetricsMatching(Criteria $criteria)
    {
        return $this->metrics->matching($criteria);
    }

    public function isDefault()
    {
        return $this->getCode() == self::CARRIER_DEFAULT;
    }

    public function getDefaultCarrier()
    {
        return $this->defaultCarrier;
    }

    public function setDefaultCarrier($defaultCarrier)
    {
        $this->defaultCarrier = $defaultCarrier;
        return $this;
    }
}