<?php

namespace BenTools\RewindableGenerator\Tests;

use BenTools\RewindableGenerator;
use PHPUnit\Framework\TestCase;

class RewindableGeneratorTest extends TestCase
{

    public function testGeneratorIsRewindable()
    {
        $generator = function () {
            yield 'foo';
            yield 'bar';
        };

        $rewindable = new RewindableGenerator($generator());
        $expected = ['foo', 'bar'];
        $this->assertEquals($expected, iterator_to_array($rewindable));
        $this->assertEquals($expected, iterator_to_array($rewindable));
        $this->assertEquals($expected, iterator_to_array($rewindable));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Cannot rewind a generator that was already run
     */
    public function testGeneratorCannotBeRewindable()
    {
        $generator = function () {
            yield 'foo';
            yield 'bar';
        };

        $rewindable = new RewindableGenerator($generator());
        $expected = ['foo', 'bar'];
        foreach ($rewindable as $value) {
            break;
        }
        iterator_to_array($rewindable);
    }
}
