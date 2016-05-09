<?php

namespace Vinci\Domain\Channel;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Channel\Contracts\Channel as ChannelInterface;
use Vinci\Domain\Product\ProductInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="channels")
 */
class Channel implements ChannelInterface
{

    const DEFAULT_CHANNEL = 'default';

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
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Product", inversedBy="channels")
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
        return $this->code == self::DEFAULT_CHANNEL;
    }

    public function addProduct(ProductInterface $product)
    {
        if (! $this->hasProduct($product)) {
            $this->products->add($product);
        }
    }

    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
    }

}