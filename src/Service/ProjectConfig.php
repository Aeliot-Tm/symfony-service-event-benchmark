<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProjectConfig
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/build')]
        private string $baseDir
    ) {
    }

    public function getBaseDir(): string
    {
        return $this->baseDir;
    }
}
