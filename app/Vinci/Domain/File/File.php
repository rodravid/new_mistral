<?php

namespace Vinci\Domain\File;

use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;

/**
 * @ORM\MappedSuperclass
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
    protected $mime;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $extension;

    /**
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    protected $upload_dir;

    public function getId()
    {
        return $this->id;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setMime($mime)
    {
        $this->mime = $mime;
        return $this;
    }

    public function getMime()
    {
        return $this->mime;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return FileType::FILE;
    }

    public function setUploadDir($dir)
    {
        $this->upload_dir = $dir;
        return $this;
    }

    public function getUploadPathName()
    {
        return $this->getPathName();
    }

    public function getPathName()
    {
        return $this->getPath() . '/' . $this->getFullName();
    }

    public function getFullName()
    {
        return $this->getName() . '.' . $this->getExtension();
    }

    public function getWebPath()
    {
        return config('app.storage_web_path') . '/' . $this->getPathName();
    }

    public function generateUniqueName()
    {
        return $this->name = md5(uniqid());
    }

}