<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class ServiceBuilder implements ClassBuilderInterface
{
    public function getClassName(string $number): string
    {
        return 'Constant' . ucfirst($number) . 'Reader';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%s;

class %s
{
    public static function getKey(): string
    {
        return '%s';
    }

    public function getContent(string $number): string
    {
        return self::getKey() . '_' . $number;
    }
}
PHP,
            $subNamespace,
            $this->getClassName($number),
            $number,
        );
    }
}
