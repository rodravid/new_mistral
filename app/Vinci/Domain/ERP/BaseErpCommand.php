<?php

namespace Vinci\Domain\ERP;

class BaseErpCommand
{

    protected $silent;

    protected $userActor;

    public function __construct($userActor = null, $silent = false)
    {
        if (empty($userActor)) {
            $userActor = $this->getDefaultUserActor();
        }

        $this->userActor = $userActor;
        $this->silent = $silent;
    }

    public function isSilent()
    {
        return $this->silent;
    }

    public function silent($val = true)
    {
        $this->silent = $val;
        return $this;
    }

    public function getUserActor()
    {
        return $this->userActor;
    }

    protected function getDefaultUserActor()
    {
        return 'Sistema';
    }

}