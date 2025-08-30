<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Temp File Create Exception
 *
 * @package Spark\Exceptions\File
 */
class TempFileCreateException extends OperationException
{
    /**
     * Temp directory
     *
     * @var string
     */
    protected string $tempDir;

    /**
     * Prefix
     *
     * @var string
     */
    protected string $prefix;

    /**
     * Constructor
     *
     * @param string $tempDir
     * @param string $prefix
     */
    public function __construct(string $tempDir, string $prefix)
    {
        $this->tempDir = $tempDir;
        $this->prefix  = $prefix;

        parent::__construct("Failed to create temporary file in directory: \"{$tempDir}\" with prefix: \"{$prefix}\"");
    }

    /**
     * Get temp directory
     *
     * @return string
     */
    public function tempDir(): string
    {
        return $this->tempDir;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }
}
