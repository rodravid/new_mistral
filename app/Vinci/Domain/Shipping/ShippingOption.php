<?php

namespace Vinci\Domain\Shipping;

use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Carrier\CarrierInterface;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Shipping\Presenter\ShippingPresenter;

class ShippingOption extends Model implements Presentable
{

    use PresentableTrait;

    protected $presenter = ShippingPresenter::class;

    private $price;

    private $deadline;

    private $carrier;

    public function __construct($price, $deadline, CarrierInterface $carrier)
    {
        $this->price = (double) $price;
        $this->deadline = (int) $deadline;
        $this->carrier = $carrier;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

}