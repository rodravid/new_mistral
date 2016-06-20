<?php

namespace Vinci\Domain\Promotion;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="promotions_items")
 */
class PromotionItem extends Model
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Promotion\Promotion", inversedBy="items")
     * @ORM\JoinColumn(name="promotion_id", onDelete="CASCADE")
     */
    protected $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product")
     */
    protected $product;

    public function getId()
    {
        return $this->id;
    }

    public function getPromotion()
    {
        return $this->promotion;
    }

    public function setPromotion(Promotion $promotion)
    {
        $this->promotion = $promotion;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    public function __call($name, array $params)
    {
        return call_user_func_array([$this->product, $name], $params);
    }

}