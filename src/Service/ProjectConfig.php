<?php

declare(strict_types=1);

namespace App\Service;

class ProjectConfig
{
    public function __construct(
        private string $baseDir
    ) {
    }

    public function getBaseDir(): string
    {
        return $this->baseDir;
    }
}
