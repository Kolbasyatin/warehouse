<?php

declare(strict_types=1);


namespace App\Infrastructure\Measuring;


class MeasuringService implements MeasuringInterface
{

    private MeasureToolInterface $measureTool;

    public function measure(MeasurableInterface $measurable)
    {
        //Запутался уже
    }

}