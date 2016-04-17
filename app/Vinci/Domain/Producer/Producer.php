<?php

namespace Vinci\Domain\Producer;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Region\Region;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Producer\DoctrineProducerRepository")
 * @ORM\Table(name="producers", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 */
class Producer extends BaseTaxonomy
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Producer\ProducerImage", mappedBy="producer", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Region\Region", inversedBy="producers")
     */
    protected $region;

    public function getImagesUploadPath()
    {
        return 'producers/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $producerImage = new ProducerImage;
        $producerImage->setImage($image);
        $producerImage->setProducer($this);
        $producerImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $producerImage);
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }

    public function belongsToRegion(Region $region)
    {
        return $this->region == $region;
    }

}