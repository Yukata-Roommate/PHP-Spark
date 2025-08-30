<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Backup Create Exception
 *
 * @package Spark\Exceptions\File
 */
class BackupCreateException extends OperationException
{
    /**
     * Original file path
     *
     * @var string
     */
    protected string $originalPath;

    /**
     * Backup path
     *
     * @var string
     */
    protected string $backupPath;

    /**
     * Constructor
     *
     * @param string $originalPath
     * @param string $backupPath
     */
    public function __construct(string $originalPath, string $backupPath)
    {
        $this->originalPath = $originalPath;
        $this->backupPath   = $backupPath;

        parent::__construct("Failed to create backup of \"{$originalPath}\" at \"{$backupPath}\"");
    }

    /**
     * Get original path
     *
     * @return string
     */
    public function originalPath(): string
    {
        return $this->originalPath;
    }

    /**
     * Get backup path
     *
     * @return string
     */
    public function backupPath(): string
    {
        return $this->backupPath;
    }
}
