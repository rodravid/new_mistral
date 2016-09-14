<?php

namespace Vinci\Domain\Order\Creation\Steps;

use InvalidArgumentException;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatusRepository;

class SetOrderTrackingStatus
{
    private $trackingStatusRepository;

    public function __construct(OrderTrackingStatusRepository $trackingStatusRepository)
    {
        $this->trackingStatusRepository = $trackingStatusRepository;
    }

    public function handle($data, $next)
    {
        try {

            $status = $this->trackingStatusRepository->getOneByCode(OrderTrackingStatus::STATUS_NEW);

            $data['order']->setTrackingStatus($status);

            return $next($data);

        } catch (Exception $e) {

            throw new InvalidArgumentException(sprintf('Order tracking status not found by code: %s', OrderTrackingStatus::STATUS_NEW));
        }
    }

}