<?php

namespace Vinci\Domain\Newsletter;

interface NewsletterRepository
{

    public function getAll();

    public function create(array $attributes);

}