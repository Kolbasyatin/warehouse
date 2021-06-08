<?php

declare(strict_types=1);


namespace App\Infrastructure\Package;


interface MovableInterface
{
    public function moveTo(string $place);
}