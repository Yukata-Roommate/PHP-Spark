<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Copy Exception
 *
 * @package Spark\Exceptions\File
 */
class CopyException extends OperationException
{
    /**
     * Source path
     *
     * @var string
     */
    protected string $sourcePath;

    /**
     * Destination path
     *
     * @var string
     */
    protected string $destinationPath;

    /**
     * Constructor
     *
     * @param string $sourcePath
     * @param string $destinationPath
     * @param string $reason
     */
    public function __construct(string $sourcePath, string $destinationPath, string $reason)
    {
        $this->sourcePath      = $sourcePath;
        $this->destinationPath = $destinationPath;

        parent::__construct("Failed to copy from \"{$sourcePath}\" to \"{$destinationPath}\": {$reason}");
    }

    /**
     * Get source path
     *
     * @return string
     */
    public function sourcePath(): string
    {
        return $this->sourcePath;
    }

    /**
     * Get destination path
     *
     * @return string
     */
    public function destinationPath(): string
    {
        return $this->destinationPath;
    }
}
