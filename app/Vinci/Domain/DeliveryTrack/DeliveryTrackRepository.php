<?php

namespace Vinci\Domain\DeliveryTrack;

interface DeliveryTrackRepository
{

    public function find($id);

    public function getAll();

    public function create(array $data);

}