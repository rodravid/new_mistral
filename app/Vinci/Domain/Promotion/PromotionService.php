<?php


namespace Vinci\Domain\Promotion;

use Doctrine\ORM\EntityManagerInterface;

class PromotionService
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


}