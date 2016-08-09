<?php

namespace Vinci\Domain\Showcase;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_showcases_items")
 */
class ShowcaseItem extends Model
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Showcase\Showcase", inversedBy="items")
     * @ORM\JoinColumn(name="showcase_id", onDelete="CASCADE")
     */
    protected $showcase;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    protected $position = 0;

    public function getId()
    {
        return $this->id;
    }

    public function getShowcase()
    {
        return $this->showcase;
    }

    public function setShowcase(Showcase $showcase)
    {
        $this->showcase = $showcase;
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

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = (int) $position;
        return $this;
    }

    public function __call($name, array $params)
    {
        return call_user_func_array([$this->product, $name], $params);
    }

}