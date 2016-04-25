<?php

namespace Vinci\App\Api\Http\Ibge\City\Transformers;

use League\Fractal\TransformerAbstract;
use Vinci\Domain\Address\City\City;

class CityTransformer extends TransformerAbstract
{

    public function transform(City $city)
    {
        return [
            'id' => $city->getId(),
            'name' => $city->getName()
        ];
    }

}