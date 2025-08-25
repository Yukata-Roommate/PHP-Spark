<?php

namespace Spark\File;

use Spark\Foundation\File\Reader;

/**
 * Text File Reader
 *
 * @package Spark\File
 */
class TextReader extends Reader
{
    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * iterate file
     *
     * @param \SplFileObject $file
     * @return \Generator
     */
    protected function iterateFile(\SplFileObject $file): \Generator
    {
        foreach ($file as $line) {
            if ($line === false) continue;

            yield rtrim($line, "\n\r");
        }
    }

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * iterate stream
     *
     * @param resource $stream
     * @return \Generator
     */
    protected function iterateStream($stream): \Generator
    {
        while (($line = fgets($stream)) !== false) {
            yield rtrim($line, "\n\r");
        }
    }
}
