<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\SEOable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Ecommerce\Purchase\Contracts\Purchasable;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "product" = "Vinci\Domain\Product\Product",
 *     "wine" = "Vinci\Domain\Product\Wine\Wine",
 *     "kit" = "Vinci\Domain\Product\Kit\Kit"
 * })
 */
class Product extends Model
{

    use Timestamps, SoftDeletes, SEOable, Schedulable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    protected $skus;

}