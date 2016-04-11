<?php

namespace Vinci\Domain\Newsletter;

interface NewsletterRepository
{

    public function create(array $attributes);

}