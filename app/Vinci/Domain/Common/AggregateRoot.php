<?php

namespace Vinci\Domain\Common;

interface AggregateRoot
{

    public function raise($event);

    public function releaseEvents();

}