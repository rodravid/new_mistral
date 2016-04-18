<?php

namespace Vinci\Domain\Grape;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Image\Image;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Grape\DoctrineGrapeRepository")
 * @ORM\Table(name="grapes", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 */
class Grape extends BaseTaxonomy
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Grape\GrapeImage", mappedBy="grape", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    public function getImagesUploadPath()
    {
        return 'grapes/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $grapeImage = new GrapeImage;
        $grapeImage->setImage($image);
        $grapeImage->setGrape($this);
        $grapeImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $grapeImage);
    }

}