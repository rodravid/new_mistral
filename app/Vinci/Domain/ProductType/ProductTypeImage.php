<?php

namespace Vinci\Domain\ProductType;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_type_images")
 */
class ProductTypeImage extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image", inversedBy="product_type")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\ProductType\ProductType", inversedBy="images")
     * @ORM\JoinColumn(name="product_type_id", referencedColumnName="id", nullable=false)
     */
    protected $product_type;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setProductType($product_type)
    {
        $this->product_type = $product_type;
        return $this;
    }

    public function getProductType()
    {
        return $this->product_type;
    }
    public function getImageVersion()
    {
        return $this->imageVersion;
    }

    public function setImageVersion($imageVersion)
    {
        $this->imageVersion = $imageVersion;
        return $this;
    }

}