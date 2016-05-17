<?php

namespace Vinci\Domain\Product\Factories;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\Attribute;
use Vinci\Domain\Product\AttributeValue;

class AttributeFactory
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(array $data)
    {
        $attribute = $this->getNewInstance($data);

        $attributeValue = new AttributeValue;

        $attributeValue
            ->setAttribute($attribute)
            ->setValue($data['value']);

        if (isset($data['id'])) {
            $attributeValue->setId($data['id']);
        }

        return $attributeValue;
    }

    public function makeCollection(array $items)
    {
        $attributes = new ArrayCollection;

        foreach ($items as $item) {

            $attribute = $this->make($item);

            if (! empty($attribute->getId())) {
                $attributes->set($attribute->getId(), $attribute);
            } else {
                $attributes->add($attribute);
            }

        }

        return $attributes;
    }

    public function getNewInstance(array $data)
    {
        if (isset($data['attribute_id']) && !empty($data['attribute_id'])) {
            return $this->entityManager->getReference(Attribute::class, $data['attribute_id']);
        }

        return new Attribute;
    }

}