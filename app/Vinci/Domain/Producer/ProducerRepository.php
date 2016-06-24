<?php

namespace Vinci\Domain\Producer;

interface ProducerRepository
{

    public function find($id);

    public function getOneBySlug($slug);

    public function getAllValidForSelectArray();

    public function create(array $data);

}