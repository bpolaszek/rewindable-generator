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

}
