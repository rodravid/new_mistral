<?php

namespace Vinci\Domain\Showcase;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
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
     * @Gedmo\SortableGroup
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

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
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Showcase\ShowcaseItem", mappedBy="showcase", cascade={"persist", "remove"}, orphanRemoval=true)
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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
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

    public function getItems()
    {
        return $this->items;
    }

    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
        return $this;
    }

    public function addItem(ShowcaseItem $item)
    {
        if (! $this->hasItem($item)) {

            $item->setShowcase($this);

            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(ShowcaseItem $item)
    {
        if ($this->hasItem($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }

    public function hasItem(ShowcaseItem $item)
    {
        return $this->items->contains($item);
    }

    public function getProducts()
    {
        $products = [];

        foreach ($this->getItems() as $item) {

            $products[] = new ProductPresenter($item->getProduct());

        }

        return $products;
    }

}