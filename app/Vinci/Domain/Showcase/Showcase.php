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
use Vinci\Domain\Image\Image;
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
     * @Gedmo\Slug(fields={"title"}, unique=true, updatable=true)
     * @ORM\Column(length=255, nullable=true)
     */
    protected $slug;

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

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Showcase\ShowcaseImage", mappedBy="showcase", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $keywords;

    public function __construct()
    {
        $this->items = new ArrayCollection;
        $this->images = new ArrayCollection;
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

    public function hasTemplate()
    {
        return ! empty($this->template);
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

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
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

    public function getWebPath()
    {
        return sprintf('/c/vitrine/%s', $this->getSlug());
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

    public function getImagesUploadPath()
    {
        return 'showcases/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $showcaseImage = new ShowcaseImage;
        $showcaseImage->setImage($image);
        $showcaseImage->setShowcase($this);
        $showcaseImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $showcaseImage);
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

}