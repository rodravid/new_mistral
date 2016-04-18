<?php

namespace Vinci\Domain\Region;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="regions_images")
 */
class RegionImage extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image", inversedBy="regions")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Region\Region", inversedBy="images")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=false)
     */
    protected $region;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    public function getRegion()
    {
        return $this->region;
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