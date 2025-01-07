<?php

declare(strict_types=1);

namespace App\Service;

interface ConstantReaderInterface
{
    public static function getKey(): string;

    public function getContent(string $number): string;
}
