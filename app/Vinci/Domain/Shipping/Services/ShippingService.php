<?php

namespace Vinci\Domain\Shipping\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Carrier\CarrierInterface;
use Vinci\Domain\Carrier\CarrierMetric;
use Vinci\Domain\Deadline\Deadline;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Domain\Promotion\Types\Shipping\ShippingPromotionLocator;
use Vinci\Domain\Shipping\Calculator\ShippingCalculatorFactory;
use Vinci\Domain\Shipping\Contracts\ShippingCarrierLocator as CarrierLocator;
use Vinci\Domain\Shipping\ShippableInterface;
use Vinci\Domain\Shipping\ShippingOption;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class ShippingService
{

    protected $carrierLocator;

    protected $calculatorFactory;

    protected $shippingPromotionLocator;

    protected $cartService;

    protected $deadlineRepository;

    public function __construct(
        CarrierLocator $carrierLocator,
        ShippingPromotionLocator $shippingPromotionLocator,
        ShippingCalculatorFactory $calculatorFactory,
        ShoppingCartService $cartService,
        DeadlineRepository $deadlineRepository
    ) {
        $this->carrierLocator = $carrierLocator;
        $this->shippingPromotionLocator = $shippingPromotionLocator;
        $this->calculatorFactory = $calculatorFactory;
        $this->cartService = $cartService;
        $this->deadlineRepository = $deadlineRepository;
    }

    public function getShippingOptionsFor(PostalCode $postalCode, ShippableInterface $shippable)
    {
        $shippingOptions = new ArrayCollection;

        $carriers = $this->locateCarriers($postalCode, $shippable);

        foreach ($carriers as $carrier) {

            $metric = $this->chooseShippingMetric($carrier);

            $shipping = $this->getShippingOption($shippable, $carrier, $metric);

            $shippingOptions->add($shipping);
        }

        return $shippingOptions;
    }

    public function getShippingByLowestPrice(PostalCode $postalCode, ShippableInterface $shippable)
    {
        $options = $this->getShippingOptionsFor($postalCode, $shippable);

        $criteria = Criteria::create()->orderBy(['price' => Criteria::ASC]);

        $shippingOption = $options->matching($criteria)->first();

        $cart = $this->cartService->getCart();

        if ($promotion = $this->shippingPromotionLocator->findOneForShoppingCart($cart, $postalCode)) {
            $shippingOption->applyPromotion($promotion);
        }

        return $shippingOption;
    }

    public function locateCarriers(PostalCode $postalCode, ShippableInterface $shippable)
    {
        return $this->carrierLocator->locate($postalCode, $shippable);
    }

    protected function getShippingOption(ShippableInterface $shippable, CarrierInterface $carrier, CarrierMetric $metric)
    {
        $calculator = $this->getShippingCalculatorFor($carrier);

        $price = $calculator->calculatePrice($shippable, $metric);

        $deadline = $this->getDeadline($shippable, $metric, $calculator);

        

        return new ShippingOption($price, $deadline, $carrier);
    }

    protected function getShippingCalculatorFor(CarrierInterface $carrier)
    {
        return $this->calculatorFactory->make($carrier->getShippingCalculator());
    }

    protected function chooseShippingMetric(CarrierInterface $carrier)
    {
        return $carrier->getMetrics()->first();
    }

    protected function getDeadline($shippable, $metric, $calculator)
    {
        $deadline = $calculator->calculateDeadline($shippable, $metric);

        $deadlineEntity = $this->deadlineRepository->getLast();

        $deadline += $deadlineEntity->getDays();

        return $deadline;
    }

}