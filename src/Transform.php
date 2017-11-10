<?php declare(strict_types=1);

namespace Meek\Stream;

/**
 * Contract for a "transform" stream.
 *
 * A transform stream is a duplex stream where the output
 * or input is manipulated in some way. Examples include
 * compression, encryption or filtration.
 *
 * @author Nathan Bishop (nbish11)
 * @copyright 2016 Nathan Bishop
 * @license MIT
 */
interface Transform extends Duplex
{
    /**
     * Manipulate the stream in some form or another.
     *
     * @param string $buffer The data to transform.
     * @return string The transformed data.
     */
    public function transform(string $buffer): string;
}
