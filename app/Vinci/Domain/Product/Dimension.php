<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Dimension
{

    /**
     * @ORM\Column(name="width", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $width;

    /**
     * @ORM\Column(name="height", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $height;

    /**
     * @ORM\Column(name="weight", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $weight;

    /**
     * @ORM\Column(name="length", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $length;

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width = null)
    {
        $this->width = (double) $width;
        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height = null)
    {
        $this->height = (double) $height;
        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight = null)
    {
        $this->weight = doubleval($weight);
        return $this;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length = null)
    {
        $this->length = (double) $length;
        return $this;
    }

}