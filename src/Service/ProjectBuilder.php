<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\Solution;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ProjectBuilder
{
    /**
     * @param iterable<StepBuilderInterface> $stepBuilders
     */
    public function __construct(
        private Filesystem $filesystem,
        #[Autowire('%kernel.project_dir%/fixture')]
        private string $fixturesDir,
        private ProjectConfig $projectConfig,
        #[AutowireIterator('app.ProjectStepBuilder')]
        private iterable $stepBuilders,
    ) {
    }

    /**
     * @param Solution[] $solutions
     */
    public function build(int $count, array $solutions, string $version): void
    {
        $this->getCopyFixtures($version);
        foreach ($this->stepBuilders as $stepBuilder) {
            $stepBuilder->build($count, $solutions);
        }
    }

    private function getCopyFixtures(string $version): void
    {
        $fixturesDir = $this->fixturesDir . '/'. $version;
        $fixturesDirLength = strlen($fixturesDir);
        $finder = (new Finder())->in($fixturesDir)->files();
        foreach ($finder as $file) {
            $source = $file->getPathname();
            $target = $this->projectConfig->getBaseDir() . '/' . substr($file->getPathname(), $fixturesDirLength + 1);
            $this->filesystem->copy($source, $target);
        }
    }
}
