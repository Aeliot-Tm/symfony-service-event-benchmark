<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class MessageHandlerBuilder implements ClassBuilderInterface
{
    public function __construct(
        private MessageBuilder $messageBuilder,
        private ServiceBuilder $serviceBuilder,
    ) {
    }

    public function getClassName(string $number): string
    {
        return 'Message' . ucfirst($number) . 'Handler';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Message\%4$s;
use App\Service\%3$s;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class %2$s
{
    public function __construct(
        private %3$s $service,
    ) {
    }
    public function __invoke(%4$s $message): string
    {
        return $this->service->getContent($message->getNumber());
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            $this->serviceBuilder->getClassName($number),
            $this->messageBuilder->getClassName($number),
        );
    }
}
