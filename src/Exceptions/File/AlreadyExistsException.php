<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\FileException;

/**
 * Already Exists Exception
 *
 * @package Spark\Exceptions\File
 */
class AlreadyExistsException extends FileException
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

        parent::__construct("File already exists: \"{$path}\"");
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
