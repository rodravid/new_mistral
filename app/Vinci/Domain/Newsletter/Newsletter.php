<?php

namespace Vinci\Domain\Newsletter;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="newsletter")
 */
class Newsletter extends Model
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $accept_promotions = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $accep_events = false;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setAcceptPromotions($accept_promotions)
    {
        $this->accept_promotions = $accept_promotions;
        return $this;
    }

    public function getAcceptPromotions()
    {
        return $this->accept_promotions;
    }

    public function setAccepEvents($accep_events)
    {
        $this->accep_events = $accep_events;
        return $this;
    }

    public function getAccepEvents()
    {
        return $this->accep_events;
    }

}