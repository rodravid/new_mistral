<?php

namespace Vinci\Domain\ACL\Module;

use Doctrine\Common\Collections\ArrayCollection;

interface ModuleRepository
{

    public function getAll();

    public function getFromRoles(ArrayCollection $roles);

    public function findByName($name);

}