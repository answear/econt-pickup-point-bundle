<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Webmozart\Assert\Assert;

readonly class OfficeCollection implements \Countable, \IteratorAggregate
{
    /**
     * @param Office[] $offices
     */
    public function __construct(
        private array $offices,
    ) {
        Assert::allIsInstanceOf($offices, Office::class);
    }

    /**
     * @return \ArrayIterator<Office>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->offices);
    }

    public function count(): int
    {
        return \count($this->offices);
    }
}
