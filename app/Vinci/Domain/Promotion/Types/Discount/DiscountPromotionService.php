<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\PromotionRepository;
use Vinci\Domain\Promotion\PromotionService;

class DiscountPromotionService extends PromotionService
{

    protected $repository;

    protected $validator;

    protected $provider;

    public function __construct(
        EntityManagerInterface $em,
        PromotionRepository $promotionRepository,
        DiscountPromotionRepository $repository,
        DiscountPromotionValidator $validator,
        DiscountPromotionProvider $provider
    ) {
        parent::__construct($em, $promotionRepository);

        $this->repository = $repository;
        $this->validator = $validator;
        $this->provider = $provider;
    }

    public function findValidPromotionFor(ProductInterface $product)
    {
        return $this->provider->findValidPromotionFor($product);
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->savePromotion($data, function() {
            $promotion = new DiscountPromotion;

            
            return $promotion;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->savePromotion($data, function() use ($id) {

            $promotion = $this->repository->find($id);
            return $promotion;
        });
    }

    protected function savePromotion($data, Closure $method)
    {
        $promotion = $method($data);

        $promotion->setScheduleFieldsFromArray($data);

        $data['channel'] = $this->entityManager->getReference(Channel::class, $data['channel']);

        $promotion->fill($data);

        $this->repository->save($promotion);

        return $promotion;
    }

}