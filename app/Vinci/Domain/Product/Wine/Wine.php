<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines")
 */
class Wine extends Product
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\GrapeContent", mappedBy="wine")
     */
    protected $grapeContent;

}