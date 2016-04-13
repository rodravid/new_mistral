<?php

namespace Vinci\Domain\Dollar;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Dollar\DoctrineDollarRepository")
 * @ORM\Table(name="dollar")
 */
class Dollar extends Model
{
    use HasOneAdminUser, Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $amount;

    public function getId()
    {
        return $this->id;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

}