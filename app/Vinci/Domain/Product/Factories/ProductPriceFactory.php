<?php

namespace Vinci\Domain\Product\Factories;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Product\ProductVariantPrice;

class ProductPriceFactory
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(array $data)
    {
        $productPrice = new ProductVariantPrice();

        if (isset($data['channel']['id'])) {

            $channel = $this->entityManager->getReference(Channel::class, $data['channel']);

            $productPrice->setChannel($channel);
        }

        $productPrice
            ->setPrice($data['price'])
            ->setCurrencyAmount($data['currency_amount'])
            ->setAliquotIpi($data['aliquot_ipi'])
            ->setDiscountType($data['discount_type'])
            ->setDiscountAmount($data['discount_value']);

        return $productPrice;

    }

    public function makeCollection(array $data)
    {
        $prices = new ArrayCollection;

        foreach ($data as $item) {

            $prices->add($this->make($item));
        }

        return $prices;
    }

}