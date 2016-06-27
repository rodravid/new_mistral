<?php

namespace Vinci\Domain\Order;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class OrderNumberGenerator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generate()
    {
        $number = substr(sha1(Uuid::uuid4()), 0, 11);

        if (! $this->existsNumber($number)) {
            return $number;
        }

        return $this->generate();
    }

    public function existsNumber($number)
    {
        $orderRepository = $this->entityManager->getRepository(Order::class);

        $qb = $orderRepository->createQueryBuilder('o');

        $qb->select('COUNT(o)')
            ->where('o.number = :number');

        $qb->setParameter('number', $number);

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }

}