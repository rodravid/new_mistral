<?php
namespace Vinci\Domain\ProductNotify;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_notify")
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
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @ORM\Column(type="string")
     */
    protected $customer_email;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = Status::EMAIL_NOT_SENDED;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $allowSimilarNotifications = Status::ALLOWED;

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
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

    public function getAllowSimilarNotifications()
    {
        return $this->allowSimilarNotifications;
    }

    public function setAllowSimilarNotifications($allowSimilarNotifications)
    {
        $this->allowSimilarNotifications = $allowSimilarNotifications;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}