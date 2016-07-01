<?php

namespace Vinci\Domain\Order\TrackingStatus;

interface OrderTrackingStatusRepository
{
    public function getAll();

    public function getOneById($id);

    public function getOneByCode($code);

}