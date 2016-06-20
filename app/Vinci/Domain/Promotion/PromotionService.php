<?php


namespace Vinci\Domain\Promotion;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\Product;

class PromotionService
{

    protected $entityManager;

    protected $promotionRepository;

    public function __construct(EntityManagerInterface $entityManager, PromotionRepository $promotionRepository)
    {
        $this->entityManager = $entityManager;
        $this->promotionRepository = $promotionRepository;
    }

    public function addItem($promotionId, $productId)
    {
        $promotion = $this->promotionRepository->getOneById($promotionId);

        $product = $this->entityManager->getReference(Product::class, $productId);

        $item = new PromotionItem;

        $item->setPromotion($promotion)
            ->setProduct($product);

        $promotion->addItem($item);

        $this->promotionRepository->save($promotion);
    }

    public function removeItem($promotionId, $item)
    {
        $promotion = $this->promotionRepository->getOneById($promotionId);

        $item = $this->entityManager->getReference(PromotionItem::class, $item);

        $promotion->removeItem($item);

        $this->promotionRepository->save($promotion);
    }


}