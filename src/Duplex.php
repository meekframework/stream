<?php declare(strict_types=1);

namespace Meek\Stream;

/**
 * Contract for a "duplex" stream.
 *
 * A duplex stream is both readable and writable and is
 * commonly used with TCP sockets or when handling files.
 *
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
interface Duplex extends Readable, Writable
{

}
