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
     * @var int
     */
    private $rewindCount = 0;

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
        return $this->iterator->valid();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->rewindCount++;

        // Second time the iterator is called => replace inner iterator by cache
        if (2 === $this->rewindCount) {
            $this->iterator = new ArrayIterator($this->iterator->getCache());
        }

        $this->iterator->rewind();
    }
}
