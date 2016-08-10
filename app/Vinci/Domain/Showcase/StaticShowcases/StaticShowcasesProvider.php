<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

interface StaticShowcasesProvider
{

    public function getShowcases();

    public function getShowcaseBySlug($slug);

}