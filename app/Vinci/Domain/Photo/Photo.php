<?php

namespace Vinci\Domain\Photo;

use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="photos")
 */
class Photo extends File
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

        $photo = static::make([
            'caption' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'width' => $dimensions[0],
            'height' => $dimensions[1]
        ]);

        return $photo;
    }

    public function getType()
    {
        return 'photo';
    }

    public function getUploadDir()
    {
        return 'photos';
    }

    public function getSmallPath()
    {
        return $this->path . '_small';
    }

    public function getMediumPath()
    {
        return $this->path . '_medium';
    }

    public function getLargerPath()
    {
        return $this->path . '_larger';
    }

}