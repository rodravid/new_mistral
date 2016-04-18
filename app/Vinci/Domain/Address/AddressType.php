<?php

namespace Vinci\Domain\Address;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class AddressType
{

    protected static $types = [
        0 => 'Residencial',
        1 => 'Comercial'
    ];

    /**
     * @ORM\Column(name="address_type_id", type="integer")
     */
    protected $id;

    public function getTitle()
    {
        return static::$types[$this->id];
    }

}