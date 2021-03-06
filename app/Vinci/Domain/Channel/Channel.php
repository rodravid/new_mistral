<?php

namespace Vinci\Domain\Channel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Channel\Contracts\Channel as ChannelInterface;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\ProductInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="channels")
 */
class Channel extends Model implements ChannelInterface
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $accessKey;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $default = false;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Product", mappedBy="channels", indexBy="id")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
        return $this;
    }

    public function isDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = (bool) $default;
        return $this;
    }

    public function addProduct(ProductInterface $product)
    {
        if (! $this->hasProduct($product)) {
            $this->products->add($product);
        }
    }

    public function hasProduct(ProductInterface $product)
    {
        return $this->products->containsKey($product->getId());
    }

    public function getProducts()
    {
        return $this->products;
    }

}