<?php

namespace Vinci\Domain\Address;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Address\City\City;
use Vinci\Domain\Core\Model;

/**
 * @ORM\MappedSuperclass
 */
abstract class Address extends Model
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
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nickname;

    /**
     * @ORM\Column(name="postal_code", type="string", length=10)
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
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Address\City\City", fetch="EAGER")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $landmark;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $receiver;

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(AddressType $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getPublicPlace()
    {
        return $this->publicPlace;
    }

    public function setPublicPlace(PublicPlace $publicPlace)
    {
        $this->publicPlace = $publicPlace;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    public function getComplement()
    {
        return $this->complement;
    }

    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function setDistrict($district)
    {
        $this->district = $district;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity(City $city)
    {
        $this->city = $city;
        return $this;
    }

    public function getState()
    {
        return $this->city->getState();
    }

    public function getCountry()
    {
        return $this->getState()->getCountry();
    }

    public function getLandmark()
    {
        return $this->landmark;
    }

    public function setLandmark($landmark)
    {
        $this->landmark = $landmark;
        return $this;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

}