<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Directory Create Exception
 *
 * @package Spark\Exceptions\File
 */
class DirectoryCreateException extends OperationException
{
    /**
     * Directory path
     *
     * @var string
     */
    protected string $path;

    /**
     * Constructor
     *
     * @param string $path
     * @param string $reason
     */
    public function __construct(string $path, string $reason)
    {
        $this->path = $path;

        parent::__construct("Failed to create directory: \"{$path}\": {$reason}");
    }

    /**
     * Get directory path
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }
}
