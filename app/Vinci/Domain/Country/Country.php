<?php

namespace Vinci\Domain\Country;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Image\Image;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Country\DoctrineCountryRepository")
 * @ORM\Table(name="countries", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 */
class Country extends BaseTaxonomy
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Country\CountryImage", mappedBy="country", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    public function getImagesUploadPath()
    {
        return 'countries/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $countryImage = new CountryImage;
        $countryImage->setImage($image);
        $countryImage->setCountry($this);
        $countryImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $countryImage);
    }

}