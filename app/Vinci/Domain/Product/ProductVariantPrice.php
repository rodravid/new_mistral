<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Pricing\Calculator\PriceCalculator;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_variants_price")
 */
class ProductVariantPrice
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductVariant", inversedBy="prices")
     * @ORM\JoinColumn(name="variant_id", referencedColumnName="id", nullable=false)
     */
    protected $variant;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Channel\Channel")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=false)
     */
    protected $channel;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(name="cost_price", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $costPrice;

    /**
     * @ORM\Column(name="currency_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $currencyAmount;

    /**
     * @ORM\Column(name="currency_original_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $currencyOriginalAmount;

    /**
     * @ORM\Column(name="discount_type", type="string", nullable=true)
     */
    protected $discountType;

    /**
     * @ORM\Column(name="discount_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $discountAmount;

    /**
     * @ORM\Column(name="aliquot_ipi", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $aliquotIpi;

    protected $priceCalculator;

    public function getPriceCalculator()
    {
        return $this->getVariant()->getPriceCalculator();
    }

    public function getVariant()
    {
        return $this->variant;
    }

    public function setVariant(ProductVariant $variant)
    {
        $this->variant = $variant;
        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
        return $this;
    }

    public function hasChannel()
    {
        return $this->channel instanceof Channel;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = (double) $price;
        return $this;
    }

    public function getCostPrice()
    {
        return $this->costPrice;
    }

    public function setCostPrice($costPrice)
    {
        $this->costPrice = (double) $costPrice;
        return $this;
    }

    public function getCurrencyAmount()
    {
        return $this->currencyAmount;
    }

    public function setCurrencyAmount($currencyAmount)
    {
        $this->currencyAmount = (double) $currencyAmount;
        return $this;
    }

    public function getCurrencyOriginalAmount()
    {
        return $this->currencyOriginalAmount;
    }

    public function setCurrencyOriginalAmount($currencyOriginalAmount)
    {
        $this->currencyOriginalAmount = $currencyOriginalAmount;
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

    public function getAliquotIpi()
    {
        return $this->aliquotIpi;
    }

    public function setAliquotIpi($aliquotIpi)
    {
        $this->aliquotIpi = (double) $aliquotIpi;
        return $this;
    }

    public function asSalePrice()
    {
        $this->assertPriceCalculatorIsDefined();

        return $this->getPriceCalculator()
            ->calculate($this->getVariant());
    }

    public function asOriginalSalePrice()
    {
        $this->assertPriceCalculatorIsDefined();

        return $this->getPriceCalculator()
            ->skipDiscounts()
            ->calculate($this->getVariant());
    }

    private function assertPriceCalculatorIsDefined()
    {
        if (! $this->getPriceCalculator()) {
            throw new \Exception('Price calculator is not defined.');
        }
    }

}