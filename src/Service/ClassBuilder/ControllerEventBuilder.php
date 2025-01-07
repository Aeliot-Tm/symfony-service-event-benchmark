<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Enum\Solution;
use App\Service\ControllerBuilderInterface;

class ControllerEventBuilder implements ControllerBuilderInterface
{
    public static function getKey(): string
    {
        return Solution::EVENT->value;
    }

    public function __construct(
        private EventBuilder $eventBuilder,
    ) {
    }

    public function getClassName(string $number): string
    {
        return 'Event' . ucfirst($number).'Controller';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Event\%4$s;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Attribute\Route;

class %2$s
{
    #[Route('/%3$s/{number}', requirements: ['number' => '%5$s'], methods: ['GET'])]
    public function number(string $number, EventDispatcherInterface $dispatcher): Response
    {
        $event = new %4$s($number);
        $dispatcher->dispatch($event);

        return new Response($event->getResult());
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            str_replace('\\', '/', $subNamespace),
            $this->eventBuilder->getClassName($number),
            $number
        );
    }
}
