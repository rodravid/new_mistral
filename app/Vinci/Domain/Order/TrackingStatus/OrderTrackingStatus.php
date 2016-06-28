<?php

namespace Vinci\Domain\Order\TrackingStatus;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_tracking_status")
 */
class OrderTrackingStatus extends Model
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="code", type="string", nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Embedded(class="Vinci\Domain\Order\TrackingStatus\MailTemplate", columnPrefix="mail_template_")
     */
    protected $mailTemplate;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getMailTemplate()
    {
        return $this->mailTemplate;
    }

    public function setMailTemplate($mailTemplate)
    {
        $this->mailTemplate = $mailTemplate;
        return $this;
    }

}