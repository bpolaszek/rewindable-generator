<?php

namespace BenTools\RewindableGenerator;

use BenTools\RewindableGenerator;
use Generator;

/**
 * @template TType
 *
 * @param iterable<TType> $iterable
 *
 * @return iterable<TType>
 */
function rewindable(iterable $iterable): iterable
{
    if ($iterable instanceof Generator) {
        return new RewindableGenerator($iterable);
    }

    return $iterable;
}
