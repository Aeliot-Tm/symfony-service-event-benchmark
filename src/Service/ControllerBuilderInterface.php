<?php

declare(strict_types=1);

namespace App\Service;

interface ControllerBuilderInterface extends ClassBuilderInterface
{
    public static function getKey(): string;
}
