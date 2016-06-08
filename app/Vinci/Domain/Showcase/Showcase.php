<?php

namespace Vinci\Domain\Showcase;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Template\Template;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Showcase\DoctrineShowcaseRepository")
 * @ORM\Table(name="products_showcases")
 */
class Showcase extends Model
{

    use Timestampable, Schedulable, HasOneAdminUser;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Template\Template")
     */
    protected $template;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    protected $position = 0;

    /**
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    protected $status = 0;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Showcase\ShowcaseItem", mappedBy="showcase", cascade={"persist"})
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
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

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = intval($position);
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(Template $template)
    {
        $this->template = $template;
        return $this;
    }

}