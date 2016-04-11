<?php

namespace Vinci\Domain\Image;

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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $small_path;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $small_width;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $small_height;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $medium_path;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $medium_width;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $medium_height;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $large_path;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $large_width;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $large_height;

    protected $uploaded_file;

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

    public static function makeFromUpload(UploadedFile $file)
    {
        $dimensions = getimagesize($file);

        $image = static::make([
            'caption' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'width' => $dimensions[0],
            'height' => $dimensions[1],
            'uploaded_file' => $file
        ]);

        return $image;
    }

    public function getType()
    {
        return 'photo';
    }

    public function getUploadDir()
    {
        return 'photos';
    }

    public function setSmall(Image $small)
    {
        $this->setSmallPath($this->getPath() . '/small')
             ->setSmallWidth($small->getWidth())
             ->setSmallHeight($small->getHeight());
    }

    public function getSmall()
    {
        $small = clone $this;
        $small->setPath($this->getSmallPath());
        $small->setWidth($this->getSmallWidth());
        $small->setHeight($this->getSmallHeight());
        return $small;
    }

    public function setMedium(Image $medium)
    {
        $this->setMediumPath($this->getPath() . '/medium')
            ->setMediumWidth($medium->getWidth())
            ->setMediumHeight($medium->getHeight());
    }

    public function getMedium()
    {
        $medium = clone $this;
        $medium->setPath($this->getMediumPath());
        $medium->setWidth($this->getMediumWidth());
        $medium->setHeight($this->getMediumHeight());
        return $medium;
    }

    public function setLarge(Image $large)
    {
        $this->setMediumPath($this->getPath() . '/large')
            ->setMediumWidth($large->getWidth())
            ->setMediumHeight($large->getHeight());
    }

    public function getLarge()
    {
        $large = clone $this;
        $large->setPath($this->getLargePath());
        $large->setWidth($this->getLargeWidth());
        $large->setHeight($this->getLargeHeight());
        return $large;
    }

    public function setSmallPath($small_path)
    {
        $this->small_path = $small_path;
        return $this;
    }

    public function getSmallPath()
    {
        return $this->small_path;
    }

    public function setSmallWidth($width)
    {
        $this->small_width = $width;
        return $this;
    }

    public function getSmallWidth()
    {
        return $this->small_width;
    }

    public function setSmallHeight($height)
    {
        $this->small_height = $height;
        return $this;
    }

    public function getSmallHeight()
    {
        return $this->small_height;
    }

    public function setMediumPath($medium_path)
    {
        $this->medium_path = $medium_path;
        return $this;
    }

    public function getMediumPath()
    {
        return $this->medium_path;
    }

    public function setMediumWidth($width)
    {
        $this->medium_width = $width;
        return $this;
    }

    public function getMediumWidth()
    {
        return $this->medium_width;
    }

    public function setMediumHeight($height)
    {
        $this->medium_height = $height;
        return $this;
    }

    public function getMediumHeight()
    {
        return $this->medium_height;
    }

    public function setLargePath($large_path)
    {
        $this->large_path = $large_path;
        return $this;
    }

    public function getLargePath()
    {
        return $this->large_path;
    }

    public function setLargeWidth($width)
    {
        $this->large_width = $width;
        return $this;
    }

    public function getLargeWidth()
    {
        return $this->large_width;
    }

    public function setLargeHeight($height)
    {
        $this->large_height = $height;
        return $this;
    }

    public function getLargeHeight()
    {
        return $this->large_height;
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

}