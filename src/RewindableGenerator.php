<?php

namespace BenTools;

use ArrayIterator;
use CachingIterator;
use Generator;
use Iterator;

/**
 * @template T
 *
 * @implements Iterator<T>
 */
final class RewindableGenerator implements Iterator
{
    /**
     * @var Iterator<T>
     */
    private Iterator $iterator;

    /** @param Generator<T> $generator */
    public function __construct(Generator $generator)
    {
        $this->iterator = new CachingIterator($generator, CachingIterator::FULL_CACHE);
    }

    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): mixed
    {
        return $this->iterator->key();
    }

    public function valid(): bool
    {
        $valid = $this->iterator->valid();
        if (false === $valid && $this->iterator instanceof CachingIterator) {
            $this->iterator = new ArrayIterator($this->iterator->getCache());
        }

        return $valid;
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }
}
