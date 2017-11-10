# MeekFramework Stream Component

[![Scrutinizer Build Status][scrutinizer-build-image]][scrutinizer-build-url]
[![Scrutinizer Code Quality][scrutinizer-code-quality-image]][scrutinizer-code-quality-url]
[![Scrutinizer Code Coverage][scrutinizer-code-coverage-image]][scrutinizer-code-coverage-url]
[![Packagist Latest Stable Version][packagist-image]][packagist-url]
[![MIT License][license-image]][license-url]

A set of interfaces for working with streams, as well as an in-memory implementation.

## Installation

With [Composer](https://getcomposer.org/):

```bash
composer require meekframework/stream
```

## Usage

Using the interfaces:

```php
// write to stdout...
class CliOutput implements Meek\Stream\Writable
{
    public function write(string $data): int
    {
        // implementation here...
    }
}

// read from stdin...
class CliInput implements Meek\Stream\Readable, Meek\Stream\Seekable
{
    // implement methods from contracts...
}
```

Using the in-memory `Buffer` class:

```php
$stream = new Buffer('hello');

$stream->read(2);   // returns 'he'
$stream->getContents(); // returns 'llo'
$stream->write(' world');

$stream->rewind();
$stream->getContents(); // returns 'hello world'
```

## Interfaces

 * Duplex
 * Lockable
 * Readable
 * Seekable
 * Transform
 * Writable

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## Credits/Authors

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.

[scrutinizer-build-url]: https://scrutinizer-ci.com/g/meekframework/stream/build-status/master
[scrutinizer-build-image]: https://scrutinizer-ci.com/g/meekframework/stream/badges/build.png?b=master
[scrutinizer-code-quality-url]: https://scrutinizer-ci.com/g/meekframework/stream/?branch=master
[scrutinizer-code-quality-image]: https://scrutinizer-ci.com/g/meekframework/stream/badges/quality-score.png?b=master
[scrutinizer-code-coverage-url]: https://scrutinizer-ci.com/g/meekframework/stream/?branch=master
[scrutinizer-code-coverage-image]: https://scrutinizer-ci.com/g/meekframework/stream/badges/coverage.png?b=master
[packagist-url]: https://packagist.org/packages/meekframework/stream
[packagist-image]: https://img.shields.io/packagist/v/meekframework/stream.svg
[license-url]: https://raw.githubusercontent.com/meekframework/stream/master/LICENSE.md
[license-image]: https://img.shields.io/badge/license-MIT-blue.svg
