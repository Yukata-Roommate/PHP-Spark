<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Archive Extract Exception
 *
 * @package Spark\Exceptions\File
 */
class ArchiveExtractException extends OperationException
{
    /**
     * Archive path
     *
     * @var string
     */
    protected string $archivePath;

    /**
     * Extract path
     *
     * @var string
     */
    protected string $extractionPath;

    /**
     * Constructor
     *
     * @param string $archivePath
     * @param string $extractionPath
     */
    public function __construct(string $archivePath, string $extractionPath)
    {
        $this->archivePath    = $archivePath;
        $this->extractionPath = $extractionPath;

        parent::__construct("Failed to extract archive \"{$archivePath}\" to \"{$extractionPath}\"");
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

    /**
     * Get extraction path
     *
     * @return string
     */
    public function extractionPath(): string
    {
        return $this->extractionPath;
    }
}
