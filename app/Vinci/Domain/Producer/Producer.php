<?php

namespace Vinci\Domain\Producer;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Image\Image;

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

}