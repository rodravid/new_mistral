<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Promotion\Promotion;

/**
 * @ORM\Entity
 * @ORM\Table(name="discount_promotions")
 */
class DiscountPromotion extends Promotion
{

}