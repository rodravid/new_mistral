<?php

namespace Vinci\Domain\Dollar;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="dollar")
 */
class Dollar extends Model
{
    use Timestamps;

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
     * @ORM\Column(type="string", length=255)
     */
    protected $amount;

    public function getId()
    {
        return $this->id;
    }


}