<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use ArrayIterator;
use IteratorAggregate;
use Countable;

abstract class AbstractCollection implements IteratorAggregate, Countable
{

    /** @var array<AbstractResourceInterface> $items */
    private array $items = [];

    /**
     * @template AbstractResource
     * @param AbstractResource ...$items Pass in with spread operator
     * @return void
     */
    abstract public function __construct(...$items);

    /**
     * Add item into collection
     * @template AbstractResource
     * @param AbstractResource $item
     * @return self<AbstractResource>
     */
    abstract public function addItem($item): AbstractCollection;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get the count of items in the collection
     *
     * @return int
     */
    public function count(): int
    {
        return $this->getIterator()->count();
    }
}
