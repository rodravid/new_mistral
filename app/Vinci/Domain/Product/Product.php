<?php

namespace Vinci\Domain\Product;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "product" = "Vinci\Domain\Product\Product",
 *     "kit" = "Vinci\Domain\Product\Kit\Kit"
 * })
 */
class Product extends Model
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $price;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    public function setCreatedAt(Carbon $date)
    {
        $this->created_at = $date;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

}