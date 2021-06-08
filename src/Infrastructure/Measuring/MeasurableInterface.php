<?php

declare(strict_types=1);


namespace App\Infrastructure\Measuring;


interface MeasurableInterface
{
    public function setDimension(DimensionInterface $dimension);
}