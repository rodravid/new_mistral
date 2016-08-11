<?php

namespace Vinci\Domain\Common;

class SEO
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function title()
    {
        if (! empty($title = $this->model->getSeoTitle())) {
            return $title;
        }

        if (property_exists($this->model, 'name')) {
            return $this->model->getName();
        }

        return $this->model->getTitle();
    }

    public function description()
    {
        if (! empty($description = $this->model->getSeoDescription())) {
            return $description;
        }

        return e($this->model->getDescription());
    }

    public function keywords()
    {
        return $this->model->getSeoKeywords();
    }

}