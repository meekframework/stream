<?php declare(strict_types=1);

namespace Meek\Stream;

use PHPUnit\Framework\TestCase;

class TransformTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsADuplexStream()
    {
        $stream = $this->createMock(Transform::class);

        $this->assertInstanceOf(Duplex::class, $stream);
    }
}
