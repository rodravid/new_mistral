<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_variants_images")
 */
class ProductVariantImage extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductVariant", inversedBy="images")
     * @ORM\JoinColumn(name="variant_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $productVariant;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setProductVariant($productVariant)
    {
        $this->productVariant = $productVariant;
        return $this;
    }

    public function getProductVariant()
    {
        return $this->productVariant;
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