<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\DeliveryTrack\DeliveryTrack;
use Vinci\Domain\Promotion\Promotion;
use Vinci\Domain\Promotion\PromotionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="shipping_promotions")
 */
class ShippingPromotion extends Promotion implements ShippingPromotionInterface
{

    /**
     * @ORM\Column(name="initial_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $initialAmount;

    /**
     * @ORM\Column(name="final_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $finalAmount;

    /**
     * @ORM\Column(name="discount_type", type="string", nullable=true)
     */
    protected $discountType;

    /**
     * @ORM\Column(name="discount_amount", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $discountAmount;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\DeliveryTrack\DeliveryTrack")
     * @ORM\JoinTable(name="shipping_promotions_delivery_tracks",
     *      joinColumns={@ORM\JoinColumn(name="promotion_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="delivery_track_id", referencedColumnName="id")}
     *      )
     */
    protected $deliveryTracks;

    public function __construct()
    {
        parent::__construct();

        $this->deliveryTracks = new ArrayCollection;
    }

    public function getInitialAmount()
    {
        return $this->initialAmount;
    }

    public function setInitialAmount($initialAmount)
    {
        $this->initialAmount = (double) $initialAmount;
        return $this;
    }

    public function getFinalAmount()
    {
        return $this->finalAmount;
    }

    public function setFinalAmount($finalAmount = null)
    {
        if (empty($finalAmount)) {
            $this->finalAmount = null;
            return $this;
        }

        $this->finalAmount = (double) $finalAmount;
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
        return PromotionInterface::TYPE_SHIPPING;
    }

    public function getDeliveryTracks()
    {
        return $this->deliveryTracks;
    }

    public function addDeliveryTrack(DeliveryTrack $track)
    {
        if (! $this->hasDeliveryTrack($track)) {
            $this->deliveryTracks->add($track);
        }

        return $this;
    }

    public function removeDeliveryTrack(DeliveryTrack $track)
    {
        if ($this->hasDeliveryTrack($track)) {
            $this->deliveryTracks->removeElement($track);
        }

        return $this;
    }

    public function removeAllDeliveryTracks()
    {
        $this->deliveryTracks->clear();

        return $this;
    }

    public function hasDeliveryTrack(DeliveryTrack $track)
    {
        return $this->deliveryTracks->contains($track);
    }

}