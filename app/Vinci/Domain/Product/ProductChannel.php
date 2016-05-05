<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

class ProductChannel
{

    /**
     * @ORM\Id
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Channel\Channel", inversedBy="products")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=false)
     */
    protected $channel;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", inversedBy="channels")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    /**
     * @ORM\Column(type="integer")
     */
    protected $stock;

    /**
     * @ORM\Column(type="integer")
     */
    protected $price;

}