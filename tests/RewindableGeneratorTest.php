<?php

use BenTools\RewindableGenerator;

it('is rewindable', function () {
    $generator = function () {
        yield 'foo';
        yield 'bar';
    };

    $rewindable = new RewindableGenerator($generator());
    $expected = ['foo', 'bar'];
    expect(iterator_to_array($rewindable))->toEqual($expected)
        ->and(iterator_to_array($rewindable))->toEqual($expected)
        ->and(iterator_to_array($rewindable))->toEqual($expected);
});

it('cannot be rewindable if it has not been fully traversed at least once', function () {
    $generator = function () {
        yield 'foo';
        yield 'bar';
    };

    $rewindable = new RewindableGenerator($generator());
    foreach ($rewindable as $value) {
        break;
    }
    iterator_to_array($rewindable);
})->throws(Exception::class, 'Cannot rewind a generator that was already run');
