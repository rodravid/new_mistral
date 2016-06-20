<?php
namespace Vinci\Domain\Product\Notify;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="notify")
 */
class ProductNotify extends Model
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product")
     */
    protected $product;

    /**
     * @ORM\Column(type="string")
     */
    protected $customer_email;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = 0;


    public function getId()
    {
        return $this->id;
    }

    public function getProductId()
    {
        return $this->product;
    }

    public function setProductId($product)
    {
        $this->product = $product;
    }

    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    public function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }
}