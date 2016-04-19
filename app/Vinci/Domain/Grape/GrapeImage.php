<?php

namespace Vinci\Domain\Grape;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="grapes_images")
 */
class GrapeImage extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image", inversedBy="grapes")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Grape\Grape", inversedBy="images")
     * @ORM\JoinColumn(name="grape_id", referencedColumnName="id", nullable=false)
     */
    protected $grape;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setGrape($grape)
    {
        $this->grape = $grape;
        return $this;
    }

    public function getGrape()
    {
        return $this->grape;
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