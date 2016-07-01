<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class DefaultShippingPromotionLocator implements ShippingPromotionLocator
{

    private $promotionRepository;

    public function __construct(ShippingPromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function findOneForShoppingCart(ShoppingCartInterface $shoppingCart, PostalCode $postalCode)
    {
        return $this->promotionRepository->findOneByPostalCodeAndAmount($postalCode, $shoppingCart->getSubtotal());
    }
}