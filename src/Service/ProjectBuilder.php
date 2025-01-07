<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\Solution;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ProjectBuilder
{
    /**
     * @param iterable<StepBuilderInterface> $stepBuilders
     */
    public function __construct(
        #[AutowireIterator('app.ProjectStepBuilder')]
        private iterable $stepBuilders
    ) {
    }

    /**
     * @param Solution[] $solutions
     */
    public function build(int $count, array $solutions): void
    {
        foreach ($this->stepBuilders as $stepBuilder) {
            $stepBuilder->build($count, $solutions);
        }
    }
}
