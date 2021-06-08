<?php

declare(strict_types=1);


namespace App\Infrastructure\Measuring;


interface MeasureToolInterface
{
    public function doDimensions(DimensionInterface $dimension): void;
}