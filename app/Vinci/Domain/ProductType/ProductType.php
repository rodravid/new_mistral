<?php

namespace Vinci\Domain\ProductType;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Image\Image;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\ProductType\DoctrineProductTypeRepository")
 * @ORM\Table(name="product_type", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 */
class ProductType extends BaseTaxonomy
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\ProductType\ProductTypeImage", mappedBy="product_type", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Product", mappedBy="productType")
     */
    protected $products;

    public function getImagesUploadPath()
    {
        return 'product_type/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $productTypeImage = new ProductTypeImage;
        $productTypeImage->setImage($image);
        $productTypeImage->setProductType($this);
        $productTypeImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $productTypeImage);
    }

    public function getBaseWebUrl()
    {
        return '/c/tipos-de-vinho/';
    }
}