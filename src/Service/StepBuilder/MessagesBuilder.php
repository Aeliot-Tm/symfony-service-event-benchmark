<?php

declare(strict_types=1);

namespace App\Service\StepBuilder;

use App\Enum\Solution;
use App\Service\ClassBuilder\MessageBuilder;
use App\Service\ClassesBuilder;
use App\Service\StepBuilderInterface;

class MessagesBuilder implements StepBuilderInterface
{
    public function __construct(
        private ClassesBuilder $classesBuilder,
        private MessageBuilder $classBuilder,
    ) {
    }

    public function build(int $count, array $solutions): void
    {
        if (!in_array(Solution::MESSENGER, $solutions, true)) {
            return;
        }

        $this->classesBuilder->build($count, 'Message', $this->classBuilder);
    }
}
