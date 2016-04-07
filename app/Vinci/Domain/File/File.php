<?php

namespace Vinci\Domain\File;

use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="files")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"photo" = "Vinci\Domain\Photo\Photo", "file" = "Vinci\Domain\File\File"})
 */
class File extends Model
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $size;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $extension;

    /**
     * @ORM\Column(type="string")
     */
    protected $path;

    public function getId()
    {
        return $this->id;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getUploadDir()
    {
        return 'files';
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getUploadPath()
    {
        return $this->getFullPath();
    }

    public function getType()
    {
        return 'file';
    }

    public function getFullPath()
    {
        return $this->getUploadDir() . '/' . $this->getPath() . '.' . $this->getExtension();
    }

    public function getWebPath()
    {
        return $this->getFullPath();
    }

}