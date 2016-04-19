<?php

namespace Vinci\Domain\Common\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SEOable
{

    /**
     * @ORM\Column(name="seo_title", type="string", nullable=true)
     */
    protected $seoTitle;

    /**
     * @ORM\Column(name="seo_description", type="text", nullable=true)
     */
    protected $seoDescription;

    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    public function setSeoTitle($title)
    {
        $this->seoTitle = $title;
        return $this;
    }

    public function setSeoDescription($description)
    {
        $this->seoDescription = $description;
        return $this;
    }

}