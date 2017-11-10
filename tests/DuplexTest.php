<?php declare(strict_types=1);

namespace Meek\Stream;

use PHPUnit\Framework\TestCase;

class DuplexTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsAReadableStream()
    {
        $stream = $this->createMock(Duplex::class);

        $this->assertInstanceOf(Readable::class, $stream);
    }

    /**
     * @coversNothing
     */
    public function testIsAWritableStream()
    {
        $stream = $this->createMock(Duplex::class);

        $this->assertInstanceOf(Writable::class, $stream);
    }
}
