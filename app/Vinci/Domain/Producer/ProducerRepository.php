<?php

namespace Vinci\Domain\Producer;

interface ProducerRepository
{

    public function find($id);

    public function create(array $data);

}