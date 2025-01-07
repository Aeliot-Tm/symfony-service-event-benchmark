<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Enum\Solution;
use App\Service\ControllerBuilderInterface;

class ControllerServiceDirectBuilder implements ControllerBuilderInterface
{
    public static function getKey(): string
    {
        return Solution::SERVICE_DIRECT->value;
    }

    public function __construct(
        private ServiceBuilder $serviceBuilder,
    ) {
    }

    public function getClassName(string $number): string
    {
        return 'ServiceDirect' . ucfirst($number).'Controller';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Service\%4$s;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class %2$s
{
    #[Route('/%3$s/{number}', requirements: ['number' => '%5$s'], methods: ['GET'])]
    public function number(string $number, %4$s $service): Response
    {
        return new Response($service->getContent($number));
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            str_replace('\\', '/', $subNamespace),
            $this->serviceBuilder->getClassName($number),
            $number
        );
    }
}
