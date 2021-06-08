<?php

declare(strict_types=1);


namespace App\Infrastructure\Measuring;


interface DimensionInterface
{
    public function addLength(int $length): void;

    public function addWidth(int $width): void;

    public function addHeight(int $height): void;

    public function addWeight(int $weight): void;
}