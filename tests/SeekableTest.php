<?php declare(strict_types=1);

namespace Meek\Stream;

use PHPUnit\Framework\TestCase;

class SeekableTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsAReadableStream()
    {
        $stream = $this->createMock(Seekable::class);

        $this->assertInstanceOf(Readable::class, $stream);
    }
}
