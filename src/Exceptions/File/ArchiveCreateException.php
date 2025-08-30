<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Archive Create Exception
 *
 * @package Spark\Exceptions\File
 */
class ArchiveCreateException extends OperationException
{
    /**
     * Source path
     *
     * @var string
     */
    protected string $sourcePath;

    /**
     * Archive path
     *
     * @var string
     */
    protected string $archivePath;

    /**
     * Constructor
     *
     * @param string $sourcePath
     * @param string $archivePath
     */
    public function __construct(string $sourcePath, string $archivePath)
    {
        $this->sourcePath  = $sourcePath;
        $this->archivePath = $archivePath;

        parent::__construct("Failed to create archive of \"{$sourcePath}\" at \"{$archivePath}\"");
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
     * Get archive path
     *
     * @return string
     */
    public function archivePath(): string
    {
        return $this->archivePath;
    }
}
