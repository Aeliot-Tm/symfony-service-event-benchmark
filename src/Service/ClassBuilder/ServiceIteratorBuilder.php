<?php

declare(strict_types=1);

namespace App\Service\ClassBuilder;

use App\Service\ClassBuilderInterface;

class ServiceIteratorBuilder implements ClassBuilderInterface
{
    public function getClassName(string $number): string
    {
        return 'AwareConstantReader';
    }

    public function getContent(string $number, string $subNamespace): string
    {
        return sprintf(
            <<<'PHP'
<?php declare(strict_types=1);

namespace App\%s;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class AwareConstantReader
{
    private array $constantReaders;

    public function __construct(
        #[AutowireIterator('app.ConstantReader')]
        iterable $constantReaders,
    ) {
        $this->constantReaders = $constantReaders instanceof \Traversable
            ? iterator_to_array($constantReaders)
            : $constantReaders;
    }

    public function getContent(string $number): string
    {
        return $this->constantReaders[$number]->getContent($number);
    }
}
PHP,
            $subNamespace,
        );
    }
}
