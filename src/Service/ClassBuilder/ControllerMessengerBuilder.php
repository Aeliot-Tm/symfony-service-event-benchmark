<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Enum\Solution;
use App\Service\ControllerBuilderInterface;

class ControllerMessengerBuilder implements ControllerBuilderInterface
{
    public static function getKey(): string
    {
        return Solution::MESSENGER->value;
    }

    public function __construct(
        private MessageBuilder $messageBuilder,
    ) {
    }

    public function getClassName(string $number): string
    {
        return 'Message' . ucfirst($number).'Controller';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%1$s;

use App\Message\%4$s;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

class %2$s
{
    #[Route('/%3$s/{number}', requirements: ['number' => '%5$s'], methods: ['GET'])]
    public function number(string $number, MessageBusInterface $messageBus): Response
    {
        $envelope = $messageBus->dispatch(new %4$s($number));
        $result = $envelope->last(HandledStamp::class)->getResult();

        return new Response($result);
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            str_replace('\\', '/', $subNamespace),
            $this->messageBuilder->getClassName($number),
            $number
        );
    }
}
