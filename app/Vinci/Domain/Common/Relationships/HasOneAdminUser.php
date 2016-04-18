<?php

namespace Vinci\Domain\Common\Relationships;

use Vinci\Domain\Admin\Admin;
use Doctrine\ORM\Mapping as ORM;

trait HasOneAdminUser
{

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Admin\Admin")
     * @ORM\JoinColumn(name="user_id", nullable=true)
     */
    protected $user;

    public function setUser(Admin $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function hasUser()
    {
        return $this->user instanceof Admin;
    }

}