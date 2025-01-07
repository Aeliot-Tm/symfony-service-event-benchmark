<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Enum\Solution;
use App\Service\ControllerBuilderInterface;

class ControllerServiceIteratorBuilder implements ControllerBuilderInterface
{
    public static function getKey(): string
    {
        return Solution::SERVICE_ITERATOR->value;
    }

    public function getClassName(string $number): string
    {
        return 'ServiceIteratorController';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Service\AwareConstantReader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class %2$s
{
    #[Route('/%3$s/{number}', methods: ['GET'])]
    public function number(string $number, AwareConstantReader $service): Response
    {
        return new Response($service->getContent($number));
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            str_replace('\\', '/', $subNamespace),
        );
    }
}
