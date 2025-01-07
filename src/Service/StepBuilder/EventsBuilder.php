<?php

declare(strict_types=1);

namespace App\Service\StepBuilder;

use App\Enum\Solution;
use App\Service\ClassBuilder\EventBuilder;
use App\Service\ClassesBuilder;
use App\Service\StepBuilderInterface;

class EventsBuilder implements StepBuilderInterface
{
    public function __construct(
        private ClassesBuilder $classesBuilder,
        private EventBuilder $classBuilder,
    ) {
    }

    public function build(int $count, array $solutions): void
    {
        if (!in_array(Solution::EVENT, $solutions, true)) {
            return;
        }

        $this->classesBuilder->build($count, 'Event', $this->classBuilder);
    }
}
