<?php

namespace Vinci\Domain\Common;

abstract class Status
{
    const DRAFT = 0;
    const ACTIVE = 1;

    const EMAIL_SENDED = 1;
    const EMAIL_NOT_SENDED = 0;

    const ALLOWED = 1;
    const NOT_ALLOWED= 0;
}