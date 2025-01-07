<?php

declare(strict_types=1);

namespace App\Service\StepBuilder;

use App\Enum\Solution;
use App\Service\ClassesBuilder;
use App\Service\ControllerBuilderInterface;
use App\Service\StepBuilderInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ControllersBuilder implements StepBuilderInterface
{
    /**
     * @var ControllerBuilderInterface[]
     */
    private array $controllerBuilders;

    /**
     * @param iterable<ControllerBuilderInterface> $controllerBuilders
     */
    public function __construct(
        private ClassesBuilder $classesBuilder,
        #[AutowireIterator('app.ControllerBuilder', defaultIndexMethod: 'getKey')]
        iterable $controllerBuilders,
    ) {
        $this->controllerBuilders = $controllerBuilders instanceof \Traversable
            ? iterator_to_array($controllerBuilders)
            : $controllerBuilders;
    }

    public function build(int $count, array $solutions): void
    {
        foreach ($solutions as $solution) {
            $subDir = sprintf('Controller/%s', str_replace(' ', '', ucwords(str_replace('_', ' ', $solution->value))));
            $classBuilder = $this->controllerBuilders[$solution->value];
            $countBuilds = $solution === Solution::SERVICE_ITERATOR ? 1 : $count;
            $this->classesBuilder->build($countBuilds, $subDir, $classBuilder);
        }
    }
}
