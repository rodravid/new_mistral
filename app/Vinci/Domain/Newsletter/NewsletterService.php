<?php

namespace Vinci\Domain\Newsletter;

use Vinci\Domain\Admin\NewsletterValidator;

class NewsletterService
{

    protected $repository;

    protected $validator;

    public function __construct(NewsletterRepository $repository, NewsletterValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $attributes)
    {

        $this->validator->throwOnFails($attributes);

    }

}