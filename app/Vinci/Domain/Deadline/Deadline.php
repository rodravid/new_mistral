<?php

namespace Vinci\Domain\Deadline;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\Deadline\DoctrineDeadlineRepository")
 * @ORM\Table(name="deadline")
 */
class Deadline extends Model
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
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $days;

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

    public function setDays($days)
    {
        $this->days = $days;
        return $this;
    }

    public function getDays()
    {
        return $this->days;
    }

}