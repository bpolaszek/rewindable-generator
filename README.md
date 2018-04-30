[![Latest Stable Version](https://poser.pugx.org/bentools/rewindable-generator/v/stable)](https://packagist.org/packages/bentools/rewindable-generator)
[![License](https://poser.pugx.org/bentools/rewindable-generator/license)](https://packagist.org/packages/bentools/rewindable-generator)
[![Build Status](https://img.shields.io/travis/bpolaszek/rewindable-generator/master.svg?style=flat-square)](https://travis-ci.org/bpolaszek/rewindable-generator)
[![Coverage Status](https://coveralls.io/repos/github/bpolaszek/rewindable-generator/badge.svg?branch=master)](https://coveralls.io/github/bpolaszek/rewindable-generator?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/bpolaszek/rewindable-generator.svg?style=flat-square)](https://scrutinizer-ci.com/g/bpolaszek/rewindable-generator)
[![Total Downloads](https://poser.pugx.org/bentools/rewindable-generator/downloads)](https://packagist.org/packages/bentools/rewindable-generator)

Rewindable generator
==============

```php
$generator = (function () {
    yield 'foo';
    yield 'bar';
})();

var_dump(iterator_to_array($generator)); // ['foo', 'bar']
var_dump(iterator_to_array($generator)); // Boom
```

> PHP Fatal error:  Uncaught Exception: Cannot traverse an already closed generator

Yes, I know. That's annoying. But here's a tiny class which will leverage a `CachingIterator` to make your generator rewindable.

Simple as:

```php
use BenTools\RewindableGenerator;

$generator = (function () {
    yield 'foo';
    yield 'bar';
})();

$iterator = new RewindableGenerator($generator);

var_dump(iterator_to_array($iterator)); // ['foo', 'bar']
var_dump(iterator_to_array($iterator)); // ['foo', 'bar']
```

**Warning:** An exception will be thrown if you intend to rewind a generator which has not reached the end (i.e you `break`the loop), since the `CachingIterator` won't have all items in cache.

Installation
------------

> composer require bentools/rewindable-generator

Tests
-----

> ./vendor/bin/phpunit
