<?php

namespace Vinci\Domain\Address;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class AddressType
{

    const RESIDENTIAL = 1;
    const COMMERCIAL = 2;

    protected static $types = [
        self::RESIDENTIAL => 'Residencial',
        self::COMMERCIAL => 'Comercial'
    ];

    /**
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return static::$types[$this->id];
    }

}