<?php

namespace Vinci\Infrastructure\Doctrine\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ToggleableFilter extends SQLFilter
{

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (! $targetEntity->reflClass->implementsInterface('Vinci\Domain\Common\Contracts\Toggleable')) {
            return '';
        }

        return sprintf('%s.visible_site = %s', $targetTableAlias, true);
    }
}