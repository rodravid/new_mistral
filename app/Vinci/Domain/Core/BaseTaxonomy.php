<?php

namespace Vinci\Domain\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Sluggable;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Traits\SEOable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Image\Image;

/**
 * @ORM\MappedSuperclass
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
abstract class BaseTaxonomy extends Model implements Sluggable
{

    use Timestampable, SoftDeletes, SEOable, HasOneAdminUser;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"}, unique=true, updatable=false)
     * @ORM\Column(length=255, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    protected $visibleSite = false;

    /**
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    protected $status = 0;

    public function __construct()
    {
        $this->images = new ArrayCollection;
    }

    public abstract function getImagesUploadPath();

    public abstract function getBaseWebUrl();

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getVisibleSite()
    {
        return $this->visibleSite;
    }

    public function setVisibleSite($visibility)
    {
        $this->visibleSite = (bool) $visibility;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = ! empty($slug) ? $slug : null;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;
        return $this;
    }

    public function removeImage(Image $image)
    {
        foreach ($this->images as $img) {
            if ($image == $img->getImage()) {
                $this->images->removeElement($img);
            }
        }
    }

    public function getImage($version)
    {
        foreach ($this->images as $relation) {
            if ($relation->getImageVersion() == $version) {
                return $relation->getImage();
            }
        }
    }

    public function hasImage($version)
    {
        return !! $this->getImage($version);
    }

    public function getWebUrl()
    {
        return env('APP_URL') . $this->getBaseWebUrl() . $this->getSlug();
    }
}