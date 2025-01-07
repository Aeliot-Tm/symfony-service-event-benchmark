<?php

declare(strict_types=1);

namespace App\Service;

interface ClassBuilderInterface
{
    public function getClassName(string $number): string;

    public function getContent(string $number, string $subNamespace): string;
}
