<?php

namespace Vinci\Domain\Promotion\Types\Shipping;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Maatwebsite\Excel\Excel;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\DeliveryTrack\DeliveryTrack;
use Vinci\Domain\Image\ImageService;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Promotion\PromotionRepository;
use Vinci\Domain\Promotion\PromotionService;

class ShippingPromotionService extends PromotionService
{

    protected $repository;

    protected $validator;

    public function __construct(
        EntityManagerInterface $em,
        PromotionRepository $promotionRepository,
        ShippingPromotionRepository $repository,
        ShippingPromotionValidator $validator,
        ImageService $imageService,
        ProductRepository $productRepository,
        Excel $excel
    ) {
        parent::__construct($em, $promotionRepository, $productRepository, $imageService, $excel);

        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->savePromotion($data, function($data) {
            $promotion = new ShippingPromotion;

            $promotion->setScheduleFieldsFromArray($data);
            $data['channel'] = $this->entityManager->getReference(Channel::class, $data['channel']);
            $promotion->fill($data);

            return $promotion;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->savePromotion($data, function($data) use ($id) {

            $promotion = $this->repository->find($id);

            $promotion->setScheduleFieldsFromArray($data);
            $data['channel'] = $this->entityManager->getReference(Channel::class, $data['channel']);
            $promotion->fill($data);

            return $promotion;
        });
    }

    protected function savePromotion($data, Closure $method)
    {
        $promotion = $method($data);

        $this->addDeliveryTracks($promotion, $data);

        $this->repository->save($promotion);

        return $promotion;
    }

    protected function addDeliveryTracks($promotion, $data)
    {
        $promotion->removeAllDeliveryTracks();
        
        foreach (array_get($data, 'deliveryTracks') as $trackId) {
            $deliveryTrack = $this->entityManager->getReference(DeliveryTrack::class, $trackId);

            $promotion->addDeliveryTrack($deliveryTrack);
        }
    }

}