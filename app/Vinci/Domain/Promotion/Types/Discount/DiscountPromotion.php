<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Pricing\Contracts\DiscountType;
use Vinci\Domain\Pricing\PriceConfiguration;
use Vinci\Domain\Promotion\Promotion;
use Vinci\Domain\Promotion\PromotionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="discount_promotions")
 */
class DiscountPromotion extends Promotion implements DiscountPromotionInterface
{

    /**
     * @ORM\Column(name="discount_type", type="string", nullable=true)
     */
    protected $discountType;

    /**
     * @ORM\Column(name="discount_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $discountAmount;

    /**
     * @ORM\Column(name="currency_original_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $currencyOriginalAmount;

    public function getCurrencyOriginalAmount()
    {
        return $this->currencyOriginalAmount;
    }

    public function setCurrencyOriginalAmount($currencyOriginalAmount)
    {
        $this->currencyOriginalAmount = (double) $currencyOriginalAmount;
        return $this;
    }

    public function getDiscountType()
    {
        return $this->discountType;
    }

    public function setDiscountType($discountType)
    {
        $this->discountType = $discountType;
        return $this;
    }

    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = (double) $discountAmount;
        return $this;
    }

    public function getType()
    {
        return PromotionInterface::TYPE_DISCOUNT;
    }

    public function getPriceConfiguration()
    {
        $configuration = new PriceConfiguration;

        $configuration
            ->setDiscountType($this->getDiscountType())
            ->setDiscountAmount($this->getDiscountAmount());

        if ($this->getDiscountType() == DiscountType::EXCHANGE_RATE) {

            $configuration
                ->setCurrencyAmount($this->getDiscountAmount())
                ->setCurrencyOriginalAmount($this->getCurrencyOriginalAmount());
        }

        return $configuration;
    }
}