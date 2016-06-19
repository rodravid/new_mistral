<?php

namespace Vinci\Domain\Promotion\Types\Discount;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Promotion\PromotionService;

class DiscountPromotionService extends PromotionService
{

    protected $repository;

    protected $validator;

    public function __construct(
        EntityManagerInterface $em,
        DiscountPromotionRepository $repository,
        DiscountPromotionValidator $validator
    ) {
        parent::__construct($em);

        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function findValidPromotionFor(ProductInterface $product)
    {
        if ($product->canBePromoted()) {

            //@TODO Procurar uma promocao de desconto válida para o produto.

        }
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

        $promotion->fill($data);

        $this->repository->save($promotion);

        return $promotion;
    }

}