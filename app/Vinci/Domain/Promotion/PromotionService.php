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

    public function addProducts($promotionId, array $products)
    {
        $promotion = $this->promotionRepository->getOneById($promotionId);

        foreach ($products as $productId) {

            $product = $this->entityManager->getReference(Product::class, $productId);

            $item = new PromotionItem;

            $item->setPromotion($promotion)
                ->setProduct($product);

            $promotion->addItem($item);
        }

        $this->promotionRepository->save($promotion);
    }

    public function addProductsFromFilters($promotionId, array $filters)
    {
        $countries = array_get($filters, 'countries', []);
        $regions = array_get($filters, 'regions', []);
        $producers = array_get($filters, 'producers', []);
        $types = array_get($filters, '$types', []);


    }

    public function addProductsFromCountries(array $countries)
    {

        dd($countries);

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