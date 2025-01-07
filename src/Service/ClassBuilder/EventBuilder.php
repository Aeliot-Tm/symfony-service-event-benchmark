<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class EventBuilder implements ClassBuilderInterface
{
    public function getClassName(string $number): string
    {
        return 'Event' . ucfirst($number);
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%s;

class %s
{
    private ?string $result = null;

    public function __construct(private string $number)
    {
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): void
    {
        $this->result = $result;
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
        );
    }
}
