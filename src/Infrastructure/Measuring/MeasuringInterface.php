<?php

declare(strict_types=1);


namespace App\Infrastructure\Measuring;


interface MeasuringInterface
{
    public function measure(MeasurableInterface $measurable);
}