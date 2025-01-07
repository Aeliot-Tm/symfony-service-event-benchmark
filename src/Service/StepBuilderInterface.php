<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\Solution;

interface StepBuilderInterface
{
    /**
     * @param Solution[] $solutions
     */
    public function build(int $count, array $solutions): void;
}
