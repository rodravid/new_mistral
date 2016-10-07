<?php

namespace Vinci\Domain\Dollar;

interface DollarProvider
{
    public function getCurrentDollarAmount();

    public function getCurrentDollar();
}