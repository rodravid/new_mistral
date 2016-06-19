<?php

namespace Vinci\Domain\Promotion;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Channel\Contracts\Channel;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\ProductInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotions")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     PromotionInterface::TYPE_DISCOUNT = "Vinci\Domain\Promotion\Types\Discount\DiscountPromotion"
 * })
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
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Channel\Channel")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=false)
     */
    protected $channel;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Product", inversedBy="promotions")
     * @ORM\JoinTable(name="promotions_products")
     */
    protected $products;

    public abstract function getType();

    public function __construct()
    {
        $this->products = new ArrayCollection;
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

    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(ProductInterface $product)
    {
        if (! $this->hasProduct($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(ProductInterface $product)
    {
        if ($this->hasProduct($product)) {
            $this->products->remove($product);
        }
    }

    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
    }

}