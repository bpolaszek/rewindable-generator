<?php

namespace BenTools;

use ArrayIterator;
use CachingIterator;
use Generator;

final class RewindableGenerator implements \Iterator
{
    /**
     * @var CachingIterator|ArrayIterator
     */
    private $iterator;

    /**
     * RewindableGenerator constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->iterator = new CachingIterator($generator, CachingIterator::FULL_CACHE);
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        $valid = $this->iterator->valid();
        if (false === $valid && $this->iterator instanceof CachingIterator) {
            $this->iterator = new ArrayIterator($this->iterator->getCache());
        }
        return $valid;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }
}
