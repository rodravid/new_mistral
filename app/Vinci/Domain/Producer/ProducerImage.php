<?php

namespace Vinci\Domain\Producer;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="producers_images")
 */
class ProducerImage extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image", inversedBy="producers")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Producer\Producer", inversedBy="images")
     * @ORM\JoinColumn(name="producer_id", referencedColumnName="id", nullable=false)
     */
    protected $producer;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setProducer($producer)
    {
        $this->producer = $producer;
        return $this;
    }

    public function getProducer()
    {
        return $this->producer;
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