<?php

namespace Vinci\Domain\Country;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries_images")
 */
class CountryImage extends Model
{
    /**
     * @ORM\Column(type="string", name="image_version")
     */
    protected $imageVersion;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Image\Image", inversedBy="countries")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    protected $image;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Country\Country", inversedBy="images")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    protected $country;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
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