<?php

namespace Vinci\Domain\Common\Traits;

use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Common\IntegrationStatus;

trait HasIntegrationStatus
{

    /**
     * @ORM\Column(type="smallint", options={"default" = IntegrationStatus::PENDING})
     */
    protected $erpIntegrationStatus = IntegrationStatus::PENDING;

    public function getErpIntegrationStatus()
    {
        return $this->erpIntegrationStatus;
    }

    public function setErpIntegrationStatus($erpIntegrationStatus)
    {
        $this->erpIntegrationStatus = $erpIntegrationStatus;
        return $this;
    }

    public function changeErpIntegrationStatus($status)
    {
        $this->erpIntegrationStatus = $status;
        return $this;
    }

    public function wasIntegrated()
    {
        return $this->erpIntegrationStatus == IntegrationStatus::INTEGRATED;
    }

}