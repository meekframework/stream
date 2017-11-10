<?php declare(strict_types=1);

namespace Meek\Stream;

use PHPUnit\Framework\TestCase;

class BufferTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function testIsADuplexStream()
    {
        $stream = new Buffer();

        $this->assertInstanceOf(Seekable::class, $stream);
    }

    /**
     * @coversNothing
     */
    public function testIsASeekableStream()
    {
        $stream = new Buffer();

        $this->assertInstanceOf(Seekable::class, $stream);
    }

    /**
     * @covers \Meek\Stream\Buffer::__construct
     */
    public function testPointerForNewStreamIsAtStart()
    {
        $stream = new Buffer();

        $this->assertEquals(0, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::__construct
     */
    public function testNewStreamHasNothingInBuffer()
    {
        $stream = new Buffer();

        $this->assertEquals('', $stream->read(512));
    }

    /**
     * @covers \Meek\Stream\Buffer::__construct
     */
    public function testCreatingNewStreamWithDataWritesToBuffer()
    {
        $stream = new Buffer('hello');

        $this->assertEquals('hello', $stream->getContents());
    }

    /**
     * @covers \Meek\Stream\Buffer::__construct
     */
    public function testCreatingNewStreamWithDataRewindsToStart()
    {
        $stream = new Buffer('hello');

        $this->assertEquals(0, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::read
     */
    public function testReadingFromEmptyStreamReturnsNothing()
    {
        $stream = new Buffer();

        $readData = $stream->read(512);

        $this->assertEquals('', $readData);
    }

    /**
     * @covers \Meek\Stream\Buffer::read
     */
    public function testReadingFromStreamAdvancesPointer()
    {
        $stream = new Buffer('hello');

        $stream->read(2);

        $this->assertEquals(2, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::read
     */
    public function testReadsOnlyAmountOfBytesAskedFor()
    {
        $stream = new Buffer('hello');

        $readData = $stream->read(2);

        $this->assertEquals('he', $readData);
    }

    /**
     * @covers \Meek\Stream\Buffer::read
     */
    public function testReadingFromBufferDoesNotAdvancePointerMoreThanBytes()
    {
        $stream = new Buffer('hello');

        $stream->read(512);

        $this->assertEquals(5, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::pipe
     */
    public function testCanPipeToWritableStream()
    {
        $stream = new Buffer('hello');

        $returnStream = $stream->pipe(new Buffer());
        $returnStream->rewind();
        $returnStreamData = $returnStream->getContents();

        $this->assertEquals('hello', $returnStreamData);
    }

    /**
     * @covers \Meek\Stream\Buffer::pipe
     */
    public function testPipingReturnsTheStreamDataWasWrittenTo()
    {
        $writable = new Buffer();
        $stream = new Buffer('hello');

        $returnStream = $stream->pipe($writable);

        $this->assertSame($writable, $returnStream);
    }

    /**
     * @covers \Meek\Stream\Buffer::write
     */
    public function testWritingDataAdvancesPointer()
    {
        $stream = new Buffer();

        $stream->write('hello');

        $this->assertEquals(5, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::write
     */
    public function testWritingDataStoresInBuffer()
    {
        $stream = new Buffer();

        $stream->write('hello');
        $stream->rewind();

        $this->assertEquals('hello', $stream->read(8));
    }

    /**
     * @covers \Meek\Stream\Buffer::write
     */
    public function testWritingDataReturnsBytesWritten()
    {
        $stream = new Buffer();

        $bytesWritten = $stream->write('hello');

        $this->assertEquals(5, $bytesWritten);
    }

    /**
     * @covers \Meek\Stream\Buffer::eof
     */
    public function testEmptyStreamisAtEOF()
    {
        $stream = new Buffer();

        $this->assertTrue($stream->eof());
    }

    /**
     * @covers \Meek\Stream\Buffer::eof
     */
    public function testStreamIsAtEOFAfterWritingData()
    {
        $stream = new Buffer();

        $stream->write('hello');

        $this->assertTrue($stream->eof());
    }

    /**
     * @covers \Meek\Stream\Buffer::eof
     */
    public function testStreamIsAtEOFAfterReadingRemainingBytes()
    {
        $stream = new Buffer('hello');

        $stream->read(512);

        $this->assertTrue($stream->eof());
    }

    /**
     * @covers \Meek\Stream\Buffer::eof
     */
    public function testStreamIsAtEOFAfterRetrievingRemainingContents()
    {
        $stream = new Buffer('hello');

        $stream->getContents();

        $this->assertTrue($stream->eof());
    }

    /**
     * @covers \Meek\Stream\Buffer::eof
     */
    public function testStreamIsNotAtEOFAfterRewinding()
    {
        $stream = new Buffer();
        $stream->write('hello');

        $stream->rewind();

        $this->assertFalse($stream->eof());
    }

    /**
     * @covers \Meek\Stream\Buffer::getSize
     */
    public function testEmptyStreamHasNoSize()
    {
        $stream = new Buffer();

        $this->assertEquals(0, $stream->getSize());
    }

    /**
     * @covers \Meek\Stream\Buffer::getSize
     */
    public function testStreamReturnsSizeOfData()
    {
        $stream = new Buffer('hello');

        $this->assertEquals(5, $stream->getSize());
    }

    /**
     * @covers \Meek\Stream\Buffer::seek
     */
    public function testThrowsErrorForInvalidSeekOperation()
    {
        $stream = new Buffer('hello');

        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid seek operation');

        $stream->seek(2, 546);
    }

    /**
     * @covers \Meek\Stream\Buffer::seek
     */
    public function testSeekSetSetsToOffset()
    {
        $stream = new Buffer('hello');

        $stream->seek(2, Seekable::SEEK_SET);

        $this->assertEquals(2, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::seek
     */
    public function testSeekCurrentAddsOffset()
    {
        $stream = new Buffer('hello');
        $stream->seek(1);

        $stream->seek(2, Seekable::SEEK_CURRENT);

        $this->assertEquals(3, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::seek
     */
    public function testSeekEndAddsOffsetToEOF()
    {
        $stream = new Buffer('hello');

        $stream->seek(-1, Seekable::SEEK_END);

        $this->assertEquals(4, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::tell
     */
    public function testPositionIsAtStartForNoData()
    {
        $stream = new Buffer();

        $this->assertEquals(0, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::rewind
     */
    public function testRewindingStreamPlacesPointerAtStart()
    {
        $stream = new Buffer();
        $stream->write('hello');

        $stream->rewind();

        $this->assertEquals(0, $stream->tell());
    }

    /**
     * @covers \Meek\Stream\Buffer::getContents
     */
    public function testGettingContentsFromEmptyBufferReturnsNothing()
    {
        $stream = new Buffer();

        $remainingData = $stream->getContents();

        $this->assertEquals('', $remainingData);
    }

    /**
     * @covers \Meek\Stream\Buffer::getContents
     */
    public function testGettingContentsReturnsRemainingDataFromBuffer()
    {
        $stream = new Buffer('hello');
        $stream->seek(2);

        $remainingData = $stream->getContents();

        $this->assertEquals('llo', $remainingData);
    }

    /**
     * @covers \Meek\Stream\Buffer::getContents
     */
    public function testGettingContentsFromStreamAdvancesPointer()
    {
        $stream = new Buffer('hello');

        $stream->getContents();

        $this->assertEquals(5, $stream->tell());
    }
}
