<?php

declare(strict_types=1);

namespace App\Service\StepBuilder;

use App\Enum\Solution;
use App\Service\ClassBuilder\ServiceBuilder;
use App\Service\ClassBuilder\ServiceIteratorBuilder;
use App\Service\ClassesBuilder;
use App\Service\StepBuilderInterface;

class ServicesBuilder implements StepBuilderInterface
{
    public function __construct(
        private ClassesBuilder $classesBuilder,
        private ServiceBuilder $classBuilder,
        private ServiceIteratorBuilder $serviceIteratorBuilder,
    ) {
    }

    public function build(int $count, array $solutions): void
    {
        $this->classesBuilder->build($count, 'Service', $this->classBuilder);

        if (in_array(Solution::SERVICE_ITERATOR, $solutions, true)) {
            $this->classesBuilder->build(1, 'Service', $this->serviceIteratorBuilder);
        }
    }
}
