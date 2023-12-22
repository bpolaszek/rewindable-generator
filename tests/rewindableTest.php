<?php

use BenTools\RewindableGenerator;

it('rewindable() accepts Generator', function () {
    $generator = function () {
        yield 'foo';
        yield 'bar';
    };

    $rewindable = RewindableGenerator\rewindable($generator());
    $expected = ['foo', 'bar'];
    expect(iterator_to_array($rewindable))->toEqual($expected)
        ->and(iterator_to_array($rewindable))->toEqual($expected);
});

it('rewindable() accepts other iterables', function () {
    $expected = ['foo', 'bar'];
    $rewindable = RewindableGenerator\rewindable($expected);
    expect($rewindable)->toEqual($expected)
        ->and($rewindable)->toEqual($expected);
});
