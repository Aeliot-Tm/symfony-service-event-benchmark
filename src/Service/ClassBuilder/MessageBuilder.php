<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class MessageBuilder implements ClassBuilderInterface
{
    public function getClassName(string $number): string
    {
        return 'Message' . ucfirst($number);
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%s;

class %s
{
    public function __construct(private string $number)
    {
    }

    public function getNumber(): string
    {
        return $this->number;
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
        );
    }
}
