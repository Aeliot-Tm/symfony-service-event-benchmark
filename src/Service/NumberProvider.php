<?php

declare(strict_types=1);

namespace App\Service;

class NumberProvider
{
    public function iterateNumbers(int $count): \Generator
    {
        for ($i = 1; $i <= $count; $i++) {
            yield dechex($i);
        }
    }
}
