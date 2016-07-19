<?php

namespace Vinci\Domain\Common;

abstract class IntegrationStatus
{
    const PENDING = 0;
    const INTEGRATED = 1;
    const FAILED = 2;
}