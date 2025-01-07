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
        #[AutowireIterator('app.ConstantReader', defaultIndexMethod: 'getKey')]
        iterable $constantReaders,
    ) {
        $this->constantReaders = $constantReaders;
    }

    public function getContent(string $number): string
    {
        if ($this->constantReaders instanceof \Traversable) {
            $this->constantReaders = iterator_to_array($constantReaders)
        }

        return $this->constantReaders[$number]->getContent($number);
    }
}
PHP,
            $subNamespace,
        );
    }
}
