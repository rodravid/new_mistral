<?php

namespace Vinci\Domain\Address;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\MappedSuperclass
 */
abstract class Address
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Embedded(class="Vinci\Domain\Address\AddressType")
     * @ORM\Column(name="address_type_id")
     */
    protected $type;

    /**
     * @ORM\Column(name="postal_code", type="integer")
     */
    protected $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Address\PublicPlace")
     * @ORM\JoinColumn(name="public_place_id")
     */
    protected $publicPlace;

    /**
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
     * @ORM\Column(type="string")
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $complement;

    /**
     * @ORM\Column(type="string")
     */
    protected $district;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Address\City\City")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $landmark;

}