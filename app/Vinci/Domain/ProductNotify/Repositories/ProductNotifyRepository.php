<?php

namespace Vinci\Domain\Product\Notify\Repositories;


interface ProductNotifyRepository
{

    public function registerNotify($data);

    public function  findOneByEmailAndProductId($data);
    
}