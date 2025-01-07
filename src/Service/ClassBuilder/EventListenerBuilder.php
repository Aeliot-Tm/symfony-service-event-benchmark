<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class EventListenerBuilder implements ClassBuilderInterface
{
    public function __construct(
        private EventBuilder $eventBuilder,
        private ServiceBuilder $serviceBuilder,
    ) {
    }

    public function getClassName(string $number): string
    {
        return 'Event' . ucfirst($number) . 'Listener';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Event\%4$s;
use App\Service\%3$s;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class %2$s
{
    public function __construct(
        private %3$s $service,
    ) {
    }
    public function __invoke(%4$s $event): void
    {
        $event->setResult($this->service->getContent($event->getNumber()));
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            $this->serviceBuilder->getClassName($number),
            $this->eventBuilder->getClassName($number),
        );
    }
}
