<?php

namespace Vinci\Domain\Specification;

final class AndSpecification extends AbstractSpecification
{
    /**
     * @var AbstractSpecification
     */
    private $one;
    /**
     * @var AbstractSpecification
     */
    private $two;

    public function __construct(AbstractSpecification $one, AbstractSpecification $two)
    {
        $this->one = $one;
        $this->two = $two;
    }

    public function isSatisfiedBy($object)
    {
        return $this->one->isSatisfiedBy($object) && $this->two->isSatisfiedBy($object);
    }

}