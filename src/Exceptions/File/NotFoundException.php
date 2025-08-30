<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\FileException;

/**
 * Not Found Exception
 *
 * @package Spark\Exceptions\File
 */
class NotFoundException extends FileException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        parent::__construct("File not found: \"{$path}\"");
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }
}
