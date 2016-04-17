<?php

namespace Vinci\Domain\Region;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Producer\Producer;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Region\DoctrineRegionRepository")
 * @ORM\Table(name="regions", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 */
class Region extends BaseTaxonomy
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Region\RegionImage", mappedBy="region", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Country\Country", inversedBy="regions")
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Producer\Producer", mappedBy="region")
     */
    protected $producers;

    public function __construct()
    {
        parent::__construct();

        $this->producers = new ArrayCollection;
    }

    public function getImagesUploadPath()
    {
        return 'regions/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $regionImage = new RegionImage;
        $regionImage->setImage($image);
        $regionImage->setRegion($this);
        $regionImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $regionImage);
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function belongsToCountry(Country $country)
    {
        return $this->country == $country;
    }

    public function addProducer(Producer $producer)
    {
        if ($this->producers->contains($producer)) {
            $this->producers->add($producer);
        }
    }

}