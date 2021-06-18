<?php

declare(strict_types=1);


namespace App\Doctrine;


use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class WarehouseFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // TODO: Implement addFilterConstraint() method.
    }

}