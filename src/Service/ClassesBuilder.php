<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ClassesBuilder
{
    public function __construct(
        private Filesystem $filesystem,
        private NumberProvider $numberProvider,
        private ProjectConfig $projectConfig,
    ) {
    }

    public function build(int $count, string $subDir, ClassBuilderInterface $classBuilder): void
    {
        $directory = implode('/', [$this->projectConfig->getBaseDir(), 'src', $subDir]);
        $subNamespace = str_replace('/', '\\', $subDir);
        $this->filesystem->mkdir($directory);
        foreach ($this->numberProvider->iterateNumbers($count) as $number) {
            file_put_contents(
                sprintf('%s/%s.php', $directory, $classBuilder->getClassName($number)),
                $classBuilder->getContent($number, $subNamespace),
            );
        }
    }
}
