<?php

namespace Vinci\Domain\Promotion;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Channel\Contracts\Channel;
use Vinci\Domain\Common\Model\DateRange;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotions")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     PromotionInterface::TYPE_DISCOUNT = "Vinci\Domain\Promotion\Types\Discount\DiscountPromotion"
 * })
 * @ORM\EntityListeners({"Vinci\Domain\Promotion\Events\Listeners\PromotionListener"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class Promotion extends Model
{

    use Timestampable, SoftDeletes, Schedulable, HasOneAdminUser;

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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;


    protected $sealImage;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status = Status::DRAFT;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Channel\Channel")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=false)
     */
    protected $channel;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Promotion\PromotionItem", mappedBy="promotion", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $items;


    public abstract function getType();

    public function __construct()
    {
        $this->items = new ArrayCollection;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(PromotionItem $item)
    {
        if (! $this->hasItem($item)) {
            
            $item->setPromotion($this);
            
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(PromotionItem $item)
    {
        if ($this->hasItem($item)) {
            $this->items->removeElement($item);
        }
    }

    public function hasItem(PromotionItem $item)
    {
        return $this->items->contains($item);
    }

    public function isValid()
    {
        return $this->status == Status::ACTIVE &&
        (new DateRange($this->getStartsAt(), $this->getExpirationAt()))->isInRange();
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

    public function isOfType($type)
    {
        return $this->getType() == $type;
    }

}