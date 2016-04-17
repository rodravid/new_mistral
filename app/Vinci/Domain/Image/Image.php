<?php

namespace Vinci\Domain\Image;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 */
class Image extends File
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $caption;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $width;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $height;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="parent", cascade={"persist", "remove"})
     */
    protected $versions;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $version_type;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="versions", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    protected $uploaded_file;

    public function __construct()
    {
        $this->versions = new ArrayCollection;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getType()
    {
        return 'photo';
    }

    public function getUploadDir()
    {
        return 'photos';
    }

    public function setUploadedFile(UploadedFile $file)
    {
        $this->uploaded_file = $file;
        return $this;
    }

    public function getUploadedFile()
    {
        return $this->uploaded_file;
    }

    public function setVersionType($version)
    {
        $this->version_type = $version;
        return $this;
    }

    public function getVersionType()
    {
        return $this->version_type;
    }

    public function setParent(Image $image)
    {
        $this->parent = $image;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getVersions()
    {
        return $this->versions;
    }

    public function hasVersions()
    {
        return !! $this->versions->count();
    }

    public function getVersion($name)
    {
        foreach ($this->versions as $image) {
            if($image->getVersionType() == $name) {
                return $image;
            }
        }
    }

    public function hasVersion($name)
    {
        return !! $this->getVersion($name);
    }

    public function addVersion($version, Image $image)
    {
        $image->setParent($this);
        $image->setVersionType($version);
        $image->setPath($this->getPath() . '/' . $version);
        $image->setName($this->getName());
        $this->versions->set($version, $image);
    }

    public function __clone()
    {
        $this->versions = new ArrayCollection;
        $this->parent = null;
    }

    public static function makeFromUpload(UploadedFile $file = null, $path = null, $copyOriginal = true, Image $defaultImage = null)
    {
        if (empty($file)) {
            return $defaultImage;
        }

        $dimensions = getimagesize($file);

        $image = static::make([
            'caption' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'width' => $dimensions[0],
            'height' => $dimensions[1],
            'uploaded_file' => $file,
            'version_type' => ImageVersion::CURRENT
        ]);

        if(! empty($path)) {
            $image->setPath($path);
        }

        $image->generateUniqueName();

        if ($copyOriginal) {
            $image->addVersion(ImageVersion::ORIGINAL, clone $image);
        }

        return $image;
    }

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Highlight\HighlightImage", mappedBy="image", cascade={"remove"})
     */
    protected $highlights;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Country\CountryImage", mappedBy="image", cascade={"remove"})
     */
    protected $countries;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Region\RegionImage", mappedBy="image", cascade={"remove"})
     */
    protected $regions;

}