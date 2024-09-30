<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Webmozart\Assert\Assert;

readonly class CityCollection implements \Countable, \IteratorAggregate
{
    public function __construct(
        private array $cities,
    ) {
        Assert::allIsInstanceOf($cities, City::class);
    }

    /**
     * @return \ArrayIterator<City>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->cities);
    }

    public function count(): int
    {
        return \count($this->cities);
    }
}
