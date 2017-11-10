<?php declare(strict_types=1);

namespace Meek\Stream;

/**
 * Contract for read-only streams.
 *
 * A read-only stream is used when reading data from a _source_.
 * For example, reading input from the console ("stdin").
 *
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
interface Readable
{
    /**
     * Retrieve content (in bytes) from the source.
     *
     * @param integer $length The amount of bytes to retrieve.
     * @return string
     */
    public function read(int $length): string;

    /**
     * Copy the contents of this stream to another.
     *
     * @param Writable $destination The stream to write to.
     * @return Writable The stream being written to.
     */
    public function pipe(Writable $destination): Writable;

    /**
     * Determines if the stream
     *
     * @return boolean
     */
    public function eof(): bool;

    /**
     * Retrieve the remaining contents in the buffer.
     *
     * @return string
     */
    public function getContents(): string;
}
